<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SymfonyComponentHttpFoundationRequest;
use Validator;

class Post extends Model
{
    //
    /**
     * create Validator Instance
     *
     * @param  IlluminateHttpRequest $request
     * @return IlluminateValidationValidator
     */
    
    public static function getValidator(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'file' => [
                    // 必須
                    'required',
                    // アップロードされたファイルであること
                    'file',
                    // 画像ファイルであること
                    'image',
                    // MIMEタイプを指定
                    'mimes:jpeg,png',
                    // 最小縦横120px 最大縦横400px
                    // 'dimensions:min_width=120,min_height=120,max_width=400,max_height=400',
                ]
            ],
            [
                'file.required' => 'ファイルは必須項目です。'
            ]
            );
        return $validator;
    }

}
