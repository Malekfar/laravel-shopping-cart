<?php

namespace Melihovv\ShoppingCart;

use Illuminate\Contracts\Support\Arrayable;

class CartItem implements Arrayable
{
    /**
     * The unique identifier of the cart item and its options.
     *
     * Used to identify shopping cart items with the same id, but with different
     * options (e.g. different color).
     *
     * @var string
     */
    private $uniqueId;

    /**
     * The identifier of the cart item.
     *
     * @var int|string
     */
    public $id;

    /**
     * The name of the cart item.
     *
     * @var string
     */
    public $name;

    /**
     * The price of the cart item.
     *
     * @var float
     */
    public $price;

    /**
     * The quantity for this cart item.
     *
     * @var int|float
     */
    public $quantity;

    /**
     * The options for this cart item.
     *
     * @var array
     */
    public $options;

    /**
     * CartItem constructor.
     *
     * @param int|string $id
     * @param string     $name
     * @param int|float  $price
     * @param int        $quantity
     * @param array      $options
     */
    public function __construct($id, $name, $price, $quantity, array $options = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->options = $options;
        $this->uniqueId = $this->generateUniqueId();
    }

    /**
     * Create a new instance from the given array.
     *
     * @param array $attributes
     *
     * @return $this
     */
    public static function fromArray(array $attributes)
    {
        return new self(
            $attributes['id'],
            $attributes['name'],
            $attributes['price'],
            $attributes['quantity'],
            array_get($attributes, 'options', [])
        );
    }

    /**
     * Generate a unique id for the cart item.
     *
     * @return string
     */
    protected function generateUniqueId()
    {
        ksort($this->options);

        return md5($this->id . serialize($this->options));
    }

    /**
     * @return string
     */
    public function getUniqueId()
    {
        return $this->uniqueId;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'uniqueId' => $this->uniqueId,
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'options' => $this->options,
        ];
    }
}
