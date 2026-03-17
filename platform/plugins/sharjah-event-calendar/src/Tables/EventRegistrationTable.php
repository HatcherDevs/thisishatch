<?php

namespace Botble\SharjahEventCalendar\Tables;

use Botble\SharjahEventCalendar\Models\Event;
use Botble\SharjahEventCalendar\Models\EventRegistration;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\Action;
use Botble\Table\HeaderActions\HeaderAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Illuminate\Database\Eloquent\Builder;

class EventRegistrationTable extends TableAbstract
{
    public ?int $eventId = null;

    public function setEvent(Event $event): self
    {
        $this->eventId = $event->id;
        return $this;
    }

    public function setup(): void
    {

        // dd($this);
        $this->model(EventRegistration::class);

        if ($this->eventId) {
            $this->addHeaderAction(
                HeaderAction::make('export')
                    ->url(route('events.registrations.export', ['event' => $this->eventId]))
                    ->label('Export CSV')
                    ->icon('fas fa-download')
                    ->color('success')
            );
        }

        $this->addActions([
            Action::make('approve')
                ->route('events.registrations.approve', ['event' => '{event_id}', 'registration' => '{id}'])
                ->label('Approve')
                ->color('success')
                ->icon('fas fa-check')
                ->permission('events.registrations.approve'),
            Action::make('reject')
                ->route('events.registrations.reject', ['event' => '{event_id}', 'registration' => '{id}'])
                ->label('Reject')
                ->color('warning')
                ->icon('fas fa-times')
                ->permission('events.registrations.reject'),
            DeleteAction::make()->route('events.registrations.destroy', ['event' => '{event_id}', 'registration' => '{id}']),
        ]);
    }

    public function columns(): array
    {
        return [
            IdColumn::make('id'),
            Column::make('event_id')->title('Event ID'),
            Column::make('registration_number')->title('Registration #'),
            Column::make('name')->title('Name'),
            Column::make('email')->title('Email'),
            Column::make('phone')->title('Phone'),
            Column::make('status')->title('Status'),
            CreatedAtColumn::make(),
        ];
    }

    public function query(): Builder
    {
        $query = $this->getModel()->query()->select([
            'id',
            'event_id',
            'registration_number',
            'name',
            'email',
            'phone',
            'status',
            'created_at',
        ]);

        if ($this->eventId) {
            $query->where('event_id', $this->eventId);
        }

        return $this->applyScopes($query);
    }
}
