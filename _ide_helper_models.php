<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

namespace Domain\Customer\Models{
/**
 * Domain\Customer\Models\Customer
 *
 * @property int $id
 * @property string $business_name
 * @property string $document_number
 * @property string $contact_name
 * @property string $phone_number
 * @property string $email
 * @property string $address
 * @property string $comments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer newModelQuery()
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer newQuery()
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer query()
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereAddress($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereBusinessName($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereComments($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereContactName($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereCreatedAt($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereDocumentNumber($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereEmail($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereId($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereLikeBusinessNameOrDocumentNameOrContactName(?string $search)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer wherePhoneNumber($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomer {}
}

namespace Domain\Service\Models{
/**
 * Domain\Service\Models\Service
 *
 * @property int $id
 * @property string $name
 * @property int $customer_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Domain\Customer\Models\Customer $customer
 * @method static \Domain\Service\Builders\ServiceBuilder|Service newModelQuery()
 * @method static \Domain\Service\Builders\ServiceBuilder|Service newQuery()
 * @method static \Domain\Service\Builders\ServiceBuilder|Service query()
 * @method static \Domain\Service\Builders\ServiceBuilder|Service whereCreatedAt($value)
 * @method static \Domain\Service\Builders\ServiceBuilder|Service whereCustomerId($value)
 * @method static \Domain\Service\Builders\ServiceBuilder|Service whereId($value)
 * @method static \Domain\Service\Builders\ServiceBuilder|Service whereLikeName(?string $name)
 * @method static \Domain\Service\Builders\ServiceBuilder|Service whereName($value)
 * @method static \Domain\Service\Builders\ServiceBuilder|Service whereStatus($value)
 * @method static \Domain\Service\Builders\ServiceBuilder|Service whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperService {}
}

namespace Domain\Subscription\Models{
/**
 * Domain\Subscription\Models\Subscription
 *
 * @property int $id
 * @property int $service_id
 * @property \Illuminate\Support\Carbon $date_from
 * @property \Illuminate\Support\Carbon $date_to
 * @property int $duration_in_months
 * @property int $grace_period_in_days
 * @property int $total_amount
 * @property string $status
 * @property string $payment_service_type
 * @property int $automatic_notification_enabled
 * @property string|null $subscription_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Domain\Subscription\Models\SubscriptionDetail> $details
 * @property-read int|null $details_count
 * @property-read \Domain\Service\Models\Service $service
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription newModelQuery()
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription newQuery()
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription query()
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereAutomaticNotificationEnabled($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereCreatedAt($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereDateFrom($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereDateTo($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereDurationInMonths($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereGracePeriodInDays($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereId($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription wherePaymentServiceType($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereServiceId($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereStatus($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereSubscriptionInfo($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereTotalAmount($value)
 * @method static \Domain\Subscription\Builders\SubscriptionBuilder|Subscription whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperSubscription {}
}

namespace Domain\Subscription\Models{
/**
 * Domain\Subscription\Models\SubscriptionDetail
 *
 * @property int $id
 * @property int $subscription_id
 * @property int $amount
 * @property string $status
 * @property string $schedule_payment_date
 * @property string|null $payed_at
 * @property string|null $payment_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Domain\Subscription\Models\Subscription $subscription
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail wherePayedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail wherePaymentInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail whereSchedulePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail whereSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperSubscriptionDetail {}
}

