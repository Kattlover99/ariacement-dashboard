<?php

return [

    'company' => [
        'description'       => 'Αλλαγή ονόματος εταιρείας, email, διεύθυνση, ΑΦΜ, κλπ',
        'name'              => 'Όνομα',
        'email'             => 'Διεύθυνση ηλ. ταχυδρομείου',
        'phone'             => 'Τηλέφωνο',
        'address'           => 'Διεύθυνση',
        'logo'              => 'Λογότυπο',
    ],

    'localisation' => [
        'description'       => 'Ορισμός οικονομικού έτους, ζώνης ώρας, μορφή ημερομηνίας και περισσότερες τοπικές επιλογές',
        'financial_start'   => 'Έναρξη Οικονομικού Έτους',
        'timezone'          => 'Ζώνη ώρας',
        'date' => [
            'format'        => 'Μορφοποίηση Ημερομηνίας',
            'separator'     => 'Διαχωριστικό ημερομηνίας',
            'dash'          => 'Παύλα (-)',
            'dot'           => 'Τελεία (.)',
            'comma'         => 'Κόμμα (,)',
            'slash'         => 'Πλαγιοκάθετος (/)',
            'space'         => 'Κενό ( )',
        ],
        'percent' => [
            'title'         => 'Θέση συμβόλου ποσοστού (%)',
            'before'        => 'Πριν από τον αριθμό',
            'after'         => 'Μετά από τον αριθμό',
        ],
        'discount_location' => [
            'name'          => 'Εμφάνιση Έκπτωσης',
            'item'          => 'Αναλυτικά',
            'total'         => 'Συνολικά',
            'both'          => 'Αναλυτικά και Συνολικά',
        ],
    ],

    'invoice' => [
        'description'       => 'Παραμετροποίηση προθέματος, αριθμόυ, όρων, υποσέλιδου κλπ τιμολογίου',
        'prefix'            => 'Πρόθεμα αριθμού',
        'digit'             => 'Αριθμός ψηφίων',
        'next'              => 'Επόμενος αριθμός',
        'logo'              => 'Λογότυπο',
        'custom'            => 'Προσαρμογή',
        'item_name'         => 'Όνομα αντικειμένου',
        'item'              => 'Αντικείμενα',
        'product'           => 'Προϊόντα',
        'service'           => 'Υπηρεσίες',
        'price_name'        => 'Όνομα τιμής',
        'price'             => 'Τιμή',
        'rate'              => 'Συντελεστής',
        'quantity_name'     => 'Όνομα ποσότητα',
        'quantity'          => 'Ποσότητα',
        'payment_terms'     => 'Όροι Πληρωμής',
        'title'             => 'Τίτλος',
        'subheading'        => 'Υποκεφαλίδα',
        'due_receipt'       => 'Εξοφλητέο με την παραλαβή',
        'due_days'          => 'Εξοφλητέο σε :days ημέρες',
        'choose_template'   => 'Επιλέξτε πρότυπο τιμολογίου',
        'default'           => 'Προεπιλεγμένο',
        'classic'           => 'Κλασικό',
        'modern'            => 'Μοντέρνο',
        'hide'              => [
            'item_name'         => 'Απόκρυψη Ονόματος Αντικειμένων',
            'item_description'  => 'Απόκρυψη Περιγραφής Αντικειμένων',
            'quantity'          => 'Απόκρυψη Ποσότητας',
            'price'             => 'Απόκρυψη Τιμής',
            'amount'            => 'Απόκρυψη Ποσού',
        ],
    ],

    'default' => [
        'description'       => 'Προεπιλεγμένος λογαριασμός, νόμισμα, γλώσσα της εταιρείας',
        'list_limit'        => 'Εγγραφές ανά σελίδα',
        'use_gravatar'      => 'Χρήση Gravatar',
        'income_category'   => 'Κατηγορία Εσόδων',
        'expense_category'  => 'Κατηγορία Εξόδων',
    ],

    'email' => [
        'description'       => 'Αλλαγή πρωτοκόλου αποστολής και προτύπων email',
        'protocol'          => 'Πρωτόκολλο',
        'php'               => 'PHP Mail',
        'smtp' => [
            'name'          => 'SMTP',
            'host'          => 'Διακομιστής SMTP',
            'port'          => 'Θύρα SMTP',
            'username'      => 'Όνομα Χρήστη SMTP',
            'password'      => 'Συνθηματικό SMTP',
            'encryption'    => 'Ασφάλεια SMTP',
            'none'          => 'Κανένα',
        ],
        'sendmail'          => 'Απεσταλμένα μηνύματα',
        'sendmail_path'     => 'Διαδρομή προς Απεσταλμένα Μηνύματα',
        'log'               => 'Αρχείο καταγραφής ηλεκτρονικών μηνυμάτων',

        'templates' => [
            'subject'                   => 'Θέμα',
            'body'                      => 'Κείμενο',
            'tags'                      => '<strong>Διαθέσιμες Ετικέτες:</strong> :tag_list',
            'invoice_new_customer'      => 'Πρότυπο Νέου Τιμολογίου (αποστολή σε πελάτη)',
            'invoice_remind_customer'   => 'Πρότυπο Υπενθύμισης Τιμολογίου (αποστολή σε πελάτη)',
            'invoice_remind_admin'      => 'Πρότυπο Υπενθύμισης Τιμολογίου (αποστολή σε διαχειριστή)',
            'invoice_recur_customer'    => 'Πρότυπο Επαναλαμβανόμενου Τιμολογίου (αποστολή σε πελάτη)',
            'invoice_recur_admin'       => 'Πρότυπο Επαναλαμβανόμενου Τιμολογίου (αποστολή σε διαχειριστή)',
            'invoice_payment_customer'  => 'Πρότυπο Λήψης Πληρωμής (αποστολή σε πελάτη)',
            'invoice_payment_admin'     => 'Πρότυπο Λήψης Πληρωμής (αποστολή σε διαχειριστή)',
            'bill_remind_admin'         => 'Πρότυπο Υπενθύμισης Λογαριασμού (αποστολή σε διαχειριστή)',
            'bill_recur_admin'          => 'Πρότυπο Επαναλαμβανόμενου Λογαριασμού (αποστολή σε διαχειριστή)',
        ],
    ],

    'scheduling' => [
        'name'              => 'Προγραμματισμός',
        'description'       => 'Αυτόματες υπενθυμίσεις και εντολή για επαναλαμβανόμενα',
        'send_invoice'      => 'Υπενθύμιση αποστολής τιμολογίου',
        'invoice_days'      => 'Αποστολή μετά από πόσες μέρες πρέπει να εξοφληθεί',
        'send_bill'         => 'Αποστολή υπενθύμισης Λογαριασμού',
        'bill_days'         => 'Αποστολή πριν από πόσες μέρες θα έπρεπε να είχε εξοφληθεί',
        'cron_command'      => 'Προγραμματισμένη Εντολή',
        'schedule_time'     => 'Ώρα εκτέλεσης',
    ],

    'categories' => [
        'description'       => 'Απεριόριστες κατηγορίες για έσοδα, έξοδα και αντικείμενα',
    ],

    'currencies' => [
        'description'       => 'Δημιουργία και διαχείριση νομισμάτων και ισοτιμιών',
    ],

    'taxes' => [
        'description'       => 'Πάγιοι, κανονικοί, συμπεριλαμβανόμενοι και σύνθετοι φορολογικοί συντελεστές',
    ],

];