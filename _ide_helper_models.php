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
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereLikeBusinessNameOrDocumentNameOrContactName(string $search)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer wherePhoneNumber($value)
 * @method static \Domain\Customer\Builders\CustomerBuilder|Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomer {}
}

