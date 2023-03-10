<div class="row" style="font-size: inherit !important">
    @stack('header_status_start')
        @if (!$hideHeaderStatus)
        <div class="{{ $classHeaderStatus }}">
            {{ trans_choice('general.statuses', 1) }}
            <br>

            <strong>
                <span class="float-left">
                    <span class="badge badge-{{ $document->status_label }}">
                        {{ trans($textHistoryStatus . $document->status) }}
                    </span>
                </span>
            </strong>
            <br><br>
        </div>
        @endif
    @stack('header_status_end')

    @stack('header_contact_start')
        @if (!$hideHeaderContact)
        <div class="{{ $classHeaderContact }}">
            {{ trans_choice($textHeaderContact, 1) }}
            <br>

            <strong>
                <span class="float-left">
                    {{ $document->contact_name }}
                </span>
            </strong>
            <br><br>
        </div>
        @endif
    @stack('header_contact_end')

    @stack('header_amount_start')
        @if (!$hideHeaderAmount)
        <div class="{{ $classHeaderAmount }}">
            {{ trans($textHeaderAmount) }}
            <br>

            <strong>
                <span class="float-left">
                    @money($document->amount_due, $document->currency_code, true)
                </span>
            </strong>
            <br><br>
        </div>
        @endif
    @stack('header_amount_end')

    @stack('header_due_at_start')
        @if (!$hideHeaderDueAt)
        <div class="{{ $classHeaderDueAt }}">
            {{ trans($textHeaderDueAt) }}
            <br>

            <strong>
                <span class="float-left">
                    @if(!empty($document->due_at)) @date($document->due_at) @endif
                </span>
            </strong>
            <br><br>
        </div>
        @endif
    @stack('header_due_at_end')
</div>
