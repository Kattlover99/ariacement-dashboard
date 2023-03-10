<tr>
    @stack('name_td_start')
        @if (!$hideItems || (!$hideName && !$hideDescription))
            <td class="item">
                @if (!$hideName)
                    {{ $item->name }}
                @endif

                @if (!$hideDescription)
                    @if (!empty($item->description))
                        <br><small>{!! \Illuminate\Support\Str::limit($item->description, 500) !!}</small>
                    @endif
                @endif

                @stack('item_custom_fields')
                @stack('item_custom_fields_' . $item->id)
            </td>
        @endif
    @stack('name_td_end')

    @stack('quantity_td_start')
        @if (!$hideQuantity)
            <td class="quantity">{{ $item->quantity }}</td>
        @endif
    @stack('quantity_td_end')

    @stack('product_unit_td_start')
        @if (!$hideQuantity)
            <td class="product_unit">{{$item->product_unit}}</td>
        @endif
    @stack('product_unit_td_end')

    @stack('meter_square_td_start')
        @if (!$hideQuantity)
            <td class="meter_square">{{$item->meter_square}}</td>
        @endif
    @stack('meter_square_td_end')

    @stack('price_td_start')
        @if (!$hidePrice)
            <td class="price">@money($item->price, $document->currency_code, true)</td>
        @endif
    @stack('price_td_end')

    @if (!$hideDiscount)
        @if (in_array(setting('localisation.discount_location', 'total'), ['item', 'both']))
            @stack('discount_td_start')
                <td class="discount">{{ $item->discount }}</td>
            @stack('discount_td_end')
        @endif
    @endif

    @stack('total_td_start')
        @if (!$hideAmount)
            <td class="total">@money($item->total, $document->currency_code, true)</td>
        @endif
    @stack('total_td_end')
</tr>
