<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    // 状態定義
    const STATUS = [
        1 => ['label' => '未着手', 'class' => 'label-danger'],
        2 => ['label' => '着手中', 'class' => 'label-info'],
        3 => ['label' => '完了', 'class' => ''],
    ];
    /**
     * 状態のラベル
     * @return string
     */

    public function getStatusLabelAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label'];
    }

    /**
     * 状態を表すHTMLクラス
     * @return string
     */
    public function getStatusClassAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class'];
    }

    /**
     * 整形した期限日
     * @return string
     */
    public function getFormattedDueDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])
            ->format('Y-m-d');
    }

    static public function dueDateOrder($due_date_arrange)
    {
        // thisを変更する必要あり
        $due_date_arrange = $this->attributes['due_date'];
        if ($due_date_arrange == 'due_date_asc') {
            return $this->orderBy('due_date', 'due_date_asc')->get();
        } elseif ($due_date_arrange == 'due_date_desc') {
            return $this->orderBy('due_date', 'due_date_desc')->get();
        // } elseif ($due_date_arrange == 'created_at_asc') {
        //     return $this->orderBy('due_date', 'created_at_asc')->get();
        // } elseif ($due_date_arrange == 'created_at_desc') {
        //     return $this->orderBy('due_date', 'created_at_desc')->get();
        } else {
            return $this->all();
        }
    }
}
