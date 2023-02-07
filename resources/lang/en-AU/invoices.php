<?php

return [

    'invoice_number'        => 'ژمارەی وەسل',
    'invoice_date'          => 'بەرواری وەسل',
    'total_price'           => 'کۆی نرخ',
    'due_date'              => 'تا بەروار',
    'order_number'          => 'ژمارەی وەسل',
    'bill_to'               => 'بۆ',

    'quantity'              => 'ژمارە',
    'price'                 => 'نرخ',
    'sub_total'             => 'کۆ',
    'discount'              => 'داشکاندن',
    'item_discount'         => 'داشکاندن بە پێی مواد',
    'tax_total'             => 'کۆی باج',
    'total'                 => 'کۆی گشتی',

    'item_name'             => 'ناوی مواد',

    'show_discount'         => ':discount% داشکاندن',
    'add_discount'          => 'زیادکردنی داشکاندن',
    'discount_desc'         => 'کۆ',

    'payment_due'           => 'کاتی پارەدان',
    'paid'                  => 'دراوە',
    'histories'             => 'پێشوو',
    'payments'              => 'پارەدانەکان',
    'add_payment'           => 'پارەدان زیاد بکە',
    'mark_paid'             => 'نیشانەی پارەی دراو',
    'mark_sent'             => 'نیشانەی ناردن',
    'mark_viewed'           => 'بینراو',
    'mark_cancelled'        => 'نیشانەی هەڵوەشاوە',
    'download_pdf'          => 'داگرتنی PDF',
    'send_mail'             => 'ناردنی ئیمەیل',
    'all_invoices'          => 'چوونە ژوورەوە بۆ بینینی هەموو وەسڵەکان',
    'create_invoice'        => 'دروستکردنی وەسڵ',
    'send_invoice'          => 'ناردنی وەسڵ',
    'get_paid'              => 'پارەی وەرگیراو',
    'accept_payments'       => 'ڕازیبون لەسەر پارەدانەکانی سەرهێڵ',

    'messages' => [
        'email_required'    => 'هیچ ناونیشانی ئیمەیڵ نیە بۆ ئەم کڕیارە!',
        'draft'             => 'This is a <b>DRAFT</b> invoice and will be reflected to charts after it gets sent.',

        'status' => [
            'created'       => 'دروستکراوە لە :date',
            'viewed'        => 'بینراوە',
            'send' => [
                'draft'     => 'نەنێردراوە',
                'sent'      => 'نێردراوە :date',
            ],
            'paid' => [
                'await'     => 'چاوەڕوانی پارەدان',
            ],
        ],
    ],

];
