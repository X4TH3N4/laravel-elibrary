<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Doğrulama Dil Satırları
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları, doğrulama sınıfı tarafından kullanılan varsayılan
    | hata mesajlarını içerir. Bazı kuralların birden fazla sürümü bulunmaktadır,
    | örneğin boyut kuralları gibi. Her bir mesajı buradan özelleştirebilirsiniz.
    |
    */

    'accepted' => ':attribute alanı kabul edilmelidir.',
    'accepted_if' => ':attribute alanı, :other :value olduğunda kabul edilmelidir.',
    'active_url' => ':attribute alanı geçerli bir URL olmalıdır.',
    'after' => ':attribute alanı, :date tarihinden sonra bir tarih olmalıdır.',
    'after_or_equal' => ':attribute alanı, :date tarihine eşit veya sonra bir tarih olmalıdır.',
    'alpha' => ':attribute alanı sadece harf içermelidir.',
    'alpha_dash' => ':attribute alanı sadece harf, rakam, tire ve alt çizgi içermelidir.',
    'alpha_num' => ':attribute alanı sadece harf ve rakam içermelidir.',
    'array' => ':attribute alanı bir dizi olmalıdır.',
    'ascii' => ':attribute alanı yalnızca tek baytlık alfasayısal karakterler ve semboller içermelidir.',
    'before' => ':attribute alanı, :date tarihinden önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute alanı, :date tarihine eşit veya önce bir tarih olmalıdır.',
    'between' => [
        'array' => ':attribute alanı :min ile :max arasında öğe içermelidir.',
        'file' => ':attribute alanı :min ile :max kilobayt arasında olmalıdır.',
        'numeric' => ':attribute alanı :min ile :max arasında olmalıdır.',
        'string' => ':attribute alanı :min ile :max karakter arasında olmalıdır.',
    ],
    'boolean' => ':attribute alanı doğru veya yanlış olmalıdır.',
    'can' => ':attribute alanı yetkisiz bir değer içeriyor.',
    'confirmed' => ':attribute alanı doğrulaması uyuşmuyor.',
    'current_password' => 'Parola yanlış.',
    'date' => ':attribute alanı geçerli bir tarih olmalıdır.',
    'date_equals' => ':attribute alanı, :date tarihine eşit olmalıdır.',
    'date_format' => ':attribute alanı, :format formatına uymalıdır.',
    'decimal' => ':attribute alanı :decimal ondalık basamağa sahip olmalıdır.',
    'declined' => ':attribute alanı reddedilmelidir.',
    'declined_if' => ':attribute alanı :other :value olduğunda reddedilmelidir.',
    'different' => ':attribute alanı ile :other farklı olmalıdır.',
    'digits' => ':attribute alanı :digits basamaklı olmalıdır.',
    'digits_between' => ':attribute alanı en az :min, en fazla :max basamaklı olmalıdır.',
    'dimensions' => ':attribute alanı geçersiz resim boyutlarına sahip.',
    'distinct' => ':attribute alanı yinelenen bir değere sahiptir.',
    'doesnt_end_with' => ':attribute alanı şu değerlerden biriyle bitmemelidir: :values.',
    'doesnt_start_with' => ':attribute alanı şu değerlerden biriyle başlamamalıdır: :values.',
    'email' => ':attribute alanı geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':attribute alanı şu değerlerden biriyle bitmelidir: :values.',
    'enum' => 'Seçili :attribute geçersiz.',
    'exists' => 'Seçili :attribute geçersiz.',
    'file' => ':attribute alanı bir dosya olmalıdır.',
    'filled' => ':attribute alanı bir değere sahip olmalıdır.',
    'gt' => [
        'array' => ':attribute alanı :value öğeden fazla olmalıdır.',
        'file' => ':attribute alanı :value kilobayttan büyük olmalıdır.',
        'numeric' => ':attribute alanı :value değerinden büyük olmalıdır.',
        'string' => ':attribute alanı :value karakterden büyük olmalıdır.',
    ],
    'gte' => [
        'array' => ':attribute alanı en az :value öğeye sahip olmalıdır.',
        'file' => ':attribute alanı en az :value kilobayt olmalıdır.',
        'numeric' => ':attribute alanı en az :value olmalıdır.',
        'string' => ':attribute alanı en az :value karakter olmalıdır.',
    ],
    'image' => ':attribute alanı bir resim olmalıdır.',
    'in' => 'Seçili :attribute geçersiz.',
    'in_array' => ':attribute alanı :other içinde bulunmalıdır.',
    'integer' => ':attribute alanı bir tamsayı olmalıdır.',
    'ip' => ':attribute alanı geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute alanı geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute alanı geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute alanı geçerli bir JSON dizesi olmalıdır.',
    'lowercase' => ':attribute alanı küçük harflerden oluşmalıdır.',
    'lt' => [
        'array' => ':attribute alanı :value öğeden az olmalıdır.',
        'file' => ':attribute alanı :value kilobayttan küçük olmalıdır.',
        'numeric' => ':attribute alanı :value değerinden küçük olmalıdır.',
        'string' => ':attribute alanı :value karakterden küçük olmalıdır.',
    ],
    'lte' => [
        'array' => ':attribute alanı en fazla :value öğeye sahip olmalıdır.',
        'file' => ':attribute alanı en fazla :value kilobayt olmalıdır.',
        'numeric' => ':attribute alanı en fazla :value olmalıdır.',
        'string' => ':attribute alanı en fazla :value karakter olmalıdır.',
    ],
    'mac_address' => ':attribute alanı geçerli bir MAC adresi olmalıdır.',
    'max' => [
        'array' => ':attribute alanı en fazla :max öğe içermelidir.',
        'file' => ':attribute alanı en fazla :max kilobayt olmalıdır.',
        'numeric' => ':attribute alanı en fazla :max olmalıdır.',
        'string' => ':attribute alanı en fazla :max karakter olmalıdır.',
    ],
    'max_digits' => ':attribute alanı en fazla :max basamağa sahip olmalıdır.',
    'mimes' => ':attribute alanı :values türünde bir dosya olmalıdır.',
    'mimetypes' => ':attribute alanı :values türünde bir dosya olmalıdır.',
    'min' => [
        'array' => ':attribute alanı en az :min öğe içermelidir.',
        'file' => ':attribute alanı en az :min kilobayt olmalıdır.',
        'numeric' => ':attribute alanı en az :min olmalıdır.',
        'string' => ':attribute alanı en az :min karakter olmalıdır.',
    ],
    'min_digits' => ':attribute alanı en az :min basamağa sahip olmalıdır.',
    'missing' => ':attribute alanı eksik olmalıdır.',
    'missing_if' => ':attribute alanı :other :value olduğunda eksik olmalıdır.',
    'missing_unless' => ':attribute alanı :other :value olmadığında eksik olmalıdır.',
    'missing_with' => ':values varken :attribute alanı eksik olmalıdır.',
    'missing_with_all' => ':values varken :attribute alanı eksik olmalıdır.',
    'multiple_of' => ':attribute alanı :value`nin katı olmalıdır.',
    'not_in' => 'Seçili :attribute geçersiz.',
    'not_regex' => ':attribute alanı formatı geçersiz.',
    'numeric' => ':attribute alanı bir sayı olmalıdır.',
    'password' => [
        'letters' => ':attribute alanı en az bir harf içermelidir.',
        'mixed' => ':attribute alanı en az bir büyük harf ve bir küçük harf içermelidir.',
        'numbers' => ':attribute alanı en az bir rakam içermelidir.',
        'symbols' => ':attribute alanı en az bir sembol içermelidir.',
        'uncompromised' => 'Verilen :attribute bir veri sızıntısında göründü. Lütfen farklı bir :attribute seçin.',
    ],
    'present' => ':attribute alanı mevcut olmalıdır.',
    'prohibited' => ':attribute alanı yasaktır.',
    'prohibited_if' => ':other :value olduğunda :attribute alanı yasaktır.',
    'prohibited_unless' => ':other :values içinde olmadığında :attribute alanı yasaktır.',
    'prohibits' => ':attribute alanı, :other varlığından men eder.',
    'regex' => ':attribute alanı formatı geçersiz.',
    'required' => ':attribute alanı gereklidir.',
    'required_array_keys' => ':values için :attribute alanı girişleri içermelidir.',
    'required_if' => ':other :value olduğunda :attribute alanı gereklidir.',
    'required_if_accepted' => ':other kabul edildiğinde :attribute alanı gereklidir.',
    'required_unless' => ':other :values içinde olduğunda :attribute alanı gereklidir.',
    'required_with' => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_with_all' => ':values mevcut olduğunda :attribute alanı gereklidir.',
    'required_without' => ':values mevcut olmadığında :attribute alanı gereklidir.',
    'required_without_all' => ':values hiçbiri mevcut olmadığında :attribute alanı gereklidir.',
    'same' => ':attribute alanı :other ile eşleşmelidir.',
    'size' => [
        'array' => ':attribute alanı :size öğe içermelidir.',
        'file' => ':attribute alanı :size kilobayt olmalıdır.',
        'numeric' => ':attribute alanı :size olmalıdır.',
        'string' => ':attribute alanı :size karakter olmalıdır.',
    ],
    'starts_with' => ':attribute alanı şu değerlerden biriyle başlamalıdır: :values.',
    'string' => ':attribute alanı bir metin olmalıdır.',
    'timezone' => ':attribute alanı geçerli bir saat dilimi olmalıdır.',
    'unique' => ':attribute zaten alınmış.',
    'uploaded' => ':attribute yüklenemedi.',
    'uppercase' => ':attribute alanı büyük harflerden oluşmalıdır.',
    'url' => ':attribute alanı geçerli bir URL olmalıdır.',
    'ulid' => ':attribute alanı geçerli bir ULID olmalıdır.',
    'uuid' => ':attribute alanı geçerli bir UUID olmalıdır.',

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Dil Satırları
    |--------------------------------------------------------------------------
    |
    | Burada, "attribute.rule" söz dizimini kullanarak belirli bir özelliğin
    | kuralı için özel doğrulama mesajları belirtebilirsiniz.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'özel-mesaj',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Özel Doğrulama Özellikleri
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki dil satırları, örneğin "email" yerine "E-Posta Adresi" gibi
    | daha okunabilir bir mesaj elde etmek için özellik yer tutucularını değiştirmek için kullanılır.
    |
    */

    'attributes' => [],

];
