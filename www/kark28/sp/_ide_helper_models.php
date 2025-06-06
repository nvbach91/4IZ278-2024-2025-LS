<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * Class Business
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Collection|BusinessManager[] $business_managers
 * @property Collection|Review[] $reviews
 * @property Collection|Service[] $services
 * @package App\Models
 * @property-read int|null $business_managers_count
 * @property-read int|null $reviews_count
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Business newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Business newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Business query()
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Business whereName($value)
 */
	class Business extends \Eloquent {}
}

namespace App\Models{
/**
 * Class BusinessManager
 *
 * @property int $id
 * @property int|null $business_id
 * @property string|null $user_id
 * @property string $permission_level
 * @property Business|null $business
 * @property User|null $user
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessManager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessManager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessManager query()
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessManager whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessManager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessManager wherePermissionLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BusinessManager whereUserId($value)
 */
	class BusinessManager extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Reservation
 *
 * @property int $id
 * @property string|null $user_id
 * @property int|null $timeslot_id
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property User|null $user
 * @property Timeslot|null $timeslot
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereTimeslotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUserId($value)
 */
	class Reservation extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Review
 *
 * @property string $user_id
 * @property int $business_id
 * @property int $rating
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property User $user
 * @property Business $business
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Service
 *
 * @property int $id
 * @property int|null $business_id
 * @property string $name
 * @property string|null $description
 * @property int $duration_minutes
 * @property float|null $price
 * @property Business|null $business
 * @property Collection|Timeslot[] $timeslots
 * @package App\Models
 * @property-read int|null $timeslots_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereBusinessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDurationMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Timeslot
 *
 * @property int $id
 * @property int|null $service_id
 * @property string|null $provider_id
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property bool|null $available
 * @property Service|null $service
 * @property User|null $user
 * @property Collection|Reservation[] $reservations
 * @package App\Models
 * @property-read int|null $reservations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot query()
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timeslot whereStartTime($value)
 */
	class Timeslot extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password_hash
 * @property bool|null $is_admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BusinessManager> $business_managers
 * @property-read int|null $business_managers_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $reservations
 * @property-read int|null $reservations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Review> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Timeslot> $timeslots
 * @property-read int|null $timeslots_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordHash($value)
 */
	class User extends \Eloquent {}
}

