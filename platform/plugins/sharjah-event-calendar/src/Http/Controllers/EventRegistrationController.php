<?php

namespace Botble\SharjahEventCalendar\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\SharjahEventCalendar\Models\Event;
use Botble\SharjahEventCalendar\Models\EventRegistration;
use Exception;
use Illuminate\Http\Request;

class EventRegistrationController extends BaseController
{
    public function index(Event $event)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::registrations.name').' - '.$event->name);
        $registrations = $event->registrations()->get();

        return view('plugins.sharjah-event-calendar::events.registrations-list-search', compact('event', 'registrations'));
    }

    public function search(Event $event, Request $request)
    {
        $q = $request->input('q', '');

        // تنظيف المدخلات من الأحرف الخطرة
        $q = strip_tags($q);
        $q = trim($q);

        $registrations = $event->registrations()
            ->where(function ($query) use ($q) {
                $query->where('registration_number', 'like', '%'.$q.'%')
                    ->orWhere('name', 'like', '%'.$q.'%')
                    ->orWhere('email', 'like', '%'.$q.'%')
                    ->orWhere('phone', 'like', '%'.$q.'%')
                    ->orWhere('status', 'like', '%'.$q.'%');
            })
            ->get();

        $result = $registrations->map(function ($registration) {
            return [
                'registration_number' => $registration->registration_number,
                'name' => $registration->name,
                'email' => $registration->email,
                'phone' => $registration->phone,
                'status' => $registration->status,
                'created_at' => $registration->created_at->format('Y-m-d H:i'),
            ];
        });

        return response()->json($result);
    }

    public function show(Event $event, EventRegistration $registration)
    {
        $this->pageTitle(trans('plugins/sharjah-event-calendar::registrations.view'));

        return view('plugins/sharjah-event-calendar::registrations.show', compact('event', 'registration'));
    }

    public function approve(Event $event, EventRegistration $registration, BaseHttpResponse $response)
    {
        try {
            $registration->approve();

            return $response->setMessage(trans('plugins/sharjah-event-calendar::registrations.approved_successfully'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function reject(Event $event, EventRegistration $registration, BaseHttpResponse $response)
    {
        try {
            $registration->reject();

            return $response->setMessage(trans('plugins/sharjah-event-calendar::registrations.rejected_successfully'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function destroy(Event $event, EventRegistration $registration, Request $request, BaseHttpResponse $response)
    {
        try {
            $registration->delete();

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function export(Event $event)
    {
        // Export functionality will be implemented with Excel export
        // For now, return a simple CSV
        $registrations = $event->registrations()->get();

        $filename = 'event-'.$event->id.'-registrations-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, ['Registration #', 'Name', 'Email', 'Phone', 'Status', 'Date']);

            foreach ($registrations as $registration) {
                fputcsv($file, [
                    $registration->registration_number,
                    $registration->name,
                    $registration->email,
                    $registration->phone,
                    $registration->status,
                    $registration->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
