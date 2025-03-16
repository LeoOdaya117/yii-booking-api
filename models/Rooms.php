<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rooms".
 *
 * @property int $id
 * @property string $room_number
 * @property string $room_type
 * @property float $price
 * @property string|null $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Bookings[] $bookings
 */
class Rooms extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const STATUS_AVAILABLE = 'available';
    const STATUS_BOOKED = 'booked';
    const STATUS_MAINTENANCE = 'maintenance';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rooms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 'available'],
            [['room_number', 'room_type', 'price'], 'required'],
            [['price'], 'number'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['room_number'], 'string', 'max' => 50],
            [['room_type'], 'string', 'max' => 100],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['room_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_number' => 'Room Number',
            'room_type' => 'Room Type',
            'price' => 'Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Bookings::class, ['room_id' => 'id']);
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_AVAILABLE => 'available',
            self::STATUS_BOOKED => 'booked',
            self::STATUS_MAINTENANCE => 'maintenance',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusAvailable()
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function setStatusToAvailable()
    {
        $this->status = self::STATUS_AVAILABLE;
    }

    /**
     * @return bool
     */
    public function isStatusBooked()
    {
        return $this->status === self::STATUS_BOOKED;
    }

    public function setStatusToBooked()
    {
        $this->status = self::STATUS_BOOKED;
    }

    /**
     * @return bool
     */
    public function isStatusMaintenance()
    {
        return $this->status === self::STATUS_MAINTENANCE;
    }

    public function setStatusToMaintenance()
    {
        $this->status = self::STATUS_MAINTENANCE;
    }
}
