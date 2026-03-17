<?php

namespace Botble\Newsletter\Http\Requests;

use Botble\Newsletter\Enums\NewsletterStatusEnum;
use Botble\Newsletter\Models\Newsletter;
use Botble\Support\Http\Requests\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class NewsletterRequest extends Request
{
    protected $errorBag = 'newsletter';

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                // 🔒 Security: التحقق من صحة Email مع DNS validation
                'email:rfc,dns',
                'max:255',
                Rule::unique((new Newsletter)->getTable())->where(function (Builder $query): void {
                    $query->where('status', NewsletterStatusEnum::SUBSCRIBED);
                }),
            ],
            'status' => Rule::in(NewsletterStatusEnum::values()),
        ];
    }
}
