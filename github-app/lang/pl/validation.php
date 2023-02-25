<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute musi zostać zaakceptowane.',
    'accepted_if' => 'Pole :attribute musi zostać zaakceptowane, gdy :other to :value.',
    'active_url' => ':attribute nie jest prawidłowym adresem URL.',
    'after' => 'attribute musi być datą późniejszą niż :date.',
    'after_or_equal' => 'Pole :attribute musi być datą późniejszą lub równą :date.',
    'alpha' => ':attribute może zawierać tylko litery.',
    'alpha_dash' => ':attribute może zawierać tylko litery, cyfry i podkreślenia.',
    'alpha_num' => ':attribute może zawierać tylko litery i cyfry.',
    'array' => 'attribute musi być tablicą.',
    'ascii' => 'Pole :attribute może zawierać tylko jednobajtowe znaki alfanumeryczne i symbole.',
    'before' => ':attribute musi być datą wcześniejszą niż :date.',
    'before_or_equal' => 'Pole :attribute musi być datą wcześniejszą lub równą :date.',
    "between" => array(
        "numeric" => ":attribute musi być wartością pomiędzy :min i :max.",
        "file"    => ":attribute musi mieć pomiędzy :min a :max kilobajtów.",
        "string"  => ":attribute musi mieć pomiędzy :min a :max znaków.",
        "array"   => ":attribute musi mieć pomiędzy :min a :max pozycji.",
    ),
    "boolean"              => "pole :attribute musi być true lub false",
    "confirmed"            => ":attribute potwierdzenie nie pasuje.",
    'current_password' => 'Hasło jest nieprawidłowe.',
    "date"                 => ":attribute nie jest prawidłową datą.",
    'date_equals' => 'Pole :attribute musi zawierać datę równą :date.',
    "date_format"          => ":attribute nie zgadza się z formatem :format.",
    'decimal' => 'Pole :attribute musi zawierać miejsca dziesiętne :decimal.',
    'declined' => 'Pole :attribute musi zostać odrzucone.',
    'declined_if' => 'Pole :attribute musi zostać odrzucone, gdy :other to :value.',
    'different' => 'Pola :attribute i :other muszą być różne.',
    "digits"               => ":attribute musi mieć :digits cyfr.",
    "digits_between"       => ":attribute musi mieć pomiędzy :min a :max cyfr.",
    'dimensions' => 'Pole :attribute ma nieprawidłowe wymiary obrazka.',
    'distinct' => 'Pole :attribute ma zduplikowaną wartość.',
    'doesnt_end_with' => 'Pole :attribute nie może kończyć się jednym z następujących: :values.',
    'doesnt_start_with' => 'Pole :attribute nie może zaczynać się od jednego z poniższych: :values.',
    "email" => ":attribute musi być poprawnym adresem e-mail.",
    'ends_with' => 'Pole :attribute musi kończyć się jednym z następujących: :values.',
    'enum' => 'Wybrany :attribute jest nieprawidłowy.',
    "exists"               => "wybrany :attribute jest nieprawidłowy.",
    'file' => 'Pole :attribute musi być plikiem.',
     'filled' => 'Pole :attribute musi mieć wartość.',
     'gt' => [
        'array' => 'Pole :attribute musi zawierać więcej elementów niż :value.',
        'file' => 'Pole :attribute musi być większe niż :value kilobajtów.',
        'numeric' => 'Pole :attribute musi być większe niż :value.',
        'string' => 'Pole :attribute musi być większe niż :value znaków.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musi zawierać elementy :value lub więcej.',
        'file' => 'Pole :attribute musi być większe lub równe :value kilobajtów.',
        'numeric' => 'Pole :attribute musi być większe lub równe :value.',
        'string' => 'Pole :attribute musi być większe lub równe :value znaków.',
    ],
    "image"                => ":attribute musi być obrazkiem.",
    "in"                   => "wybrany :attribute jest nieprawidłowy.",
    'in_array' => 'Pole :attribute musi istnieć w :other.',
    "integer"              => ":attribute musi być liczbą.",
    "ip"                   => ":attribute musi być poprawnym adresem IP.",
    'ipv4' => ':attribute musi być poprawnym adresem IPv4.',
    'ipv6' => ':attribute musi być poprawnym adresem IPv6.',
    'json' => 'Pole :attribute musi być prawidłowym ciągiem JSON.',
    'lowercase' => 'Pole :attribute musi być pisane małymi literami.',
    'lt' => [
        'array' => 'Pole :attribute musi zawierać mniej niż :value pozycji.',
        'file' => 'Pole :attribute musi być mniejsze niż :value kilobajtów.',
        'numeric' => 'Pole :attribute musi być mniejsze niż :value.',
        'string' => 'Pole :attribute musi być mniejsze niż :value znaków.',
    ],
    'lte' => [
        'array' => 'Pole :attribute nie może zawierać więcej niż :value pozycji.',
        'file' => 'Pole :attribute musi być mniejsze lub równe :value kilobajtów.',
        'numeric' => 'Pole :attribute musi być mniejsze lub równe :value.',
        'string' => 'Pole :attribute musi być mniejsze lub równe :value znaków.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    "max"                  => array(
        "numeric" => ":attribute nie może być większy niż :max.",
        "file"    => ":attribute nie może być większy niż :max kilobajtów.",
        "string"  => ":attribute nie może być dłuższy niż :max znaków.",
        "array"   => ":attribute nie może mieć więcej niż :max pozycji.",
    ),
    'max_digits' => 'Pole :attribute nie może zawierać więcej niż :max cyfr.',
    'mimes' => 'Pole :attribute musi być plikiem typu: :values.',
    'mimetypes' => 'Pole :attribute musi być plikiem typu: :values.',
    'min' => [
        'array' => 'Pole :attribute musi zawierać co najmniej :min pozycji.',
        'file' => 'Pole :attribute musi mieć co najmniej :min kilobajtów.',
        'numeric' => 'Pole :attribute musi mieć co najmniej :min.',
        'string' => 'Pole :attribute musi mieć co najmniej :min znaków.',
    ],
    'min_digits' => 'Pole :attribute musi mieć co najmniej :min cyfr.',
    'missing' => 'Brakuje pola :attribute.',
    'missing_if' => 'Pola :attribute musi brakować, gdy :other to :value.',
    'missing_unless' => 'Pola :attribute musi brakować, chyba że :other to :value.',
    'missing_with' => 'Pola :attribute musi brakować, gdy obecne jest :values.',
    'missing_with_all' => 'Pola :attribute musi brakować, gdy obecne są :values.',
    'multiple_of' => 'Pole :attribute musi być wielokrotnością :value.',
    'not_in' => 'Wybrany :attribute jest nieprawidłowy.',
    'not_regex' => 'Format pola :attribute jest nieprawidłowy.',
    'numeric' => 'Pole :attribute musi być liczbą.',
    'hasło' => [
        'letters' => 'Pole :attribute musi zawierać co najmniej jedną literę.',
        'mixed' => 'Pole :attribute musi zawierać co najmniej jedną wielką i jedną małą literę.',
        'numbers' => 'Pole :attribute musi zawierać co najmniej jedną liczbę.',
        'symbols' => 'Pole :attribute musi zawierać co najmniej jeden symbol.',
        'uncompromised' => 'Podany :attribute pojawił się w wycieku danych. Wybierz inny :attribute.',
    ],
    'present' => 'Pole :attribute musi być obecne.',
    'prohibited' => 'Pole :attribute jest zabronione.',
    'prohibited_if' => 'Pole :attribute jest zabronione, gdy :other to :value.',
    'prohibited_unless' => 'Pole :attribute jest zabronione, chyba że :other jest w :values.',
    'prohibits' => 'Pole :attribute zabrania obecności :other.',
    'regex' => 'Format pola :attribute jest nieprawidłowy.',
    'required' => 'Pole :attribute jest wymagane.',
    'required_array_keys' => 'Pole :attribute musi zawierać wpisy dla: :values.',
    'required_if' => 'Pole :attribute jest wymagane, gdy :other to :value.',
    'required_if_accepted' => 'Pole :attribute jest wymagane, gdy akceptowane jest :other.',
    'required_unless' => 'Pole :attribute jest wymagane, chyba że :other jest w :values.',
    'required_with' => 'Pole :attribute jest wymagane, gdy obecne jest :values.',
    'required_with_all' => 'Pole :attribute jest wymagane, gdy obecne są :values.',
    'required_without' => 'Pole :attribute jest wymagane, gdy nie ma :values.',
    'required_without_all' => 'Pole :attribute jest wymagane, gdy nie ma żadnych :wartości.',
    'same' => 'Pole :attribute musi pasować do :other.',
    'size' => [
        'array' => 'Pole :attribute musi zawierać elementy :size.',
        'file' => 'Pole :attribute musi mieć postać :size kilobytes.',
        'numeric' => 'Pole :attribute musi mieć postać :size.',
        'string' => 'Pole :attribute musi zawierać :size znaków.',
    ],
    'starts_with' => 'Pole :attribute musi zaczynać się od jednego z poniższych: :values.',
    'string' => 'Pole :attribute musi być ciągiem znaków.',
    'timezone' => 'Pole :attribute musi być prawidłową strefą czasową.',
    'unique' => 'Pole :attribute zostało już zajęte.',
    'uploaded' => 'Przesłanie :attribute nie powiodło się.',
    'uppercase' => 'Pole :attribute musi być pisane wielkimi literami.',
    'url' => 'Pole :attribute musi być prawidłowym adresem URL.',
    'ulid' => 'Pole :attribute musi być poprawnym ULID.',
    'uuid' => 'Pole :attribute musi być prawidłowym identyfikatorem UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
