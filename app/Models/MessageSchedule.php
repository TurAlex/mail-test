<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * Class MessageSchedule
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property int $message_id
 * @property string $time
 * @property-read User[]|Collection|null $users
 * @property-read Message $message
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageScheduleUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageScheduleUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageScheduleUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageScheduleUser whereMessageScheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageScheduleUser whereUserId($value)
 */
class MessageSchedule extends Model
{

    protected $table = 'message_schedule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message_id',
        'time',
    ];

    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function message() :BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * @return BelongsToMany
     */
    public function users() :BelongsToMany
    {
        return $this->belongsToMany(User::class,'message_schedule_user');
    }

}
