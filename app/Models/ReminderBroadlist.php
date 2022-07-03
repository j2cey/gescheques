<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ReminderBroadlist
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $title
 * @property string $broadlist_role
 * @property string $msg
 * @property string|null $description
 *
 * @property integer $notification_interval
 * @property Carbon $notification_start_at
 * @property Carbon $notification_last_time
 * @property Carbon $notification_end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ReminderBroadlist extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Validation Rules

    public static function defaultRules() {
        return [
            'title' => 'required',
            'roles' => [
                'required_if:users,=,null'
            ],
            'users' => [
                'required_if:roles,=,null'
            ],
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function messagesRules() {
        return [
            'title.required' => 'The Title is required',
            'roles.required_if' => 'At least one role is required if no user is given',
            'users.required_if' => 'At least one user is required if no role is given',
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function roles() {
        return $this->belongsToMany(Role::class, 'reminder_broadlist_role', 'broadlist_id', 'role_id')
            ->withPivot('custom_msg', 'description')
            ;
    }

    public function users() {
        return $this->belongsToMany(User::class, 'reminder_broadlist_user', 'broadlist_id', 'user_id')
            ->withPivot('custom_msg', 'description')
            ;
    }

    #endregion

    #region Custom Functions - CRUD

    public static function createNew($title, $msg, $notification_interval = null, $description = null, $broadlist_role = null): ReminderBroadlist {
        $broadcastlist = ReminderBroadlist::create([
            'title' => $title,
            'broadlist_role' => $broadlist_role,
            'msg' => $msg,
            'notification_interval' => is_null( $notification_interval ) ? config('Settings.reminder.notification.default_interval') : $notification_interval,
            'description' => $description,
        ]);

        $broadcastlist->save();

        return $broadcastlist;
    }

    public function syncRoles($role_ids) : ReminderBroadlist {
        $this->roles()->sync($role_ids);

        $this->refresh();

        return $this;
    }

    public function syncUsers($user_ids) : ReminderBroadlist {
        $this->users()->sync($user_ids);

        $this->refresh();

        return $this;
    }

    #endregion

    #region Custom Functions

    public function setNotificationEnd() {
        $this->notification_last_time = Carbon::now();
    }

    #endregion
}
