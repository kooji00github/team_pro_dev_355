<?php

return [
    'required' => ':attributeは必須です。',
    'string' => ':attributeは文字列でなければなりません。',
    'max' => [
        'string' => ':attributeは:max文字以内である必要があります。',
    ],
    'email' => '有効なメールアドレスを入力してください。',
    'unique' => 'この:attributeは既に使用されています。',
    'min' => [
        'string' => ':attributeは:min文字以上である必要があります。',
    ],
    'confirmed' => ':attributeの確認が一致しません。',
    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'type' => 'タイプ',
        'detail' => '詳細',
    ],
];
