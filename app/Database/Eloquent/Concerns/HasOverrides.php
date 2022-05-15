<?php

namespace App\Database\Eloquent\Concerns;

use Illuminate\Support\Carbon;

/**
 * @property-read bool $json_pretty_print Определяет, требуется ли ...
 */
trait HasOverrides {

    #region DateTime

    /**
     * @inheritDoc
     */
    public function fromDateTime($value) {
        return empty($value) ? $value : $this->asDateTime($value)->setTimezone('UTC')->format(
            $this->getDateFormat()
        );
    }

    /**
     * @inheritDoc
     */
    public function asDateTime($value) {
        if (is_string($value))
            return Carbon::parse($value, 'UTC');

        return parent::asDateTime($value);
    }

    #endregion

    #region Array

    /**
     * @inheritDoc
     */
    public function fromJson($value, $asObject = false) {
        $data = json_decode($value, !$asObject);

        if (!$asObject)
            $data = is_null($data) ? [] : $data;

        return $data;
    }

    /**
     * @inheritDoc
     */
    protected function asJson($value) {
        $options = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

        if (isset($this->json_pretty_print) && $this->json_pretty_print === true)
            $options |= JSON_PRETTY_PRINT;

        return (empty($value))
            ? null
            : json_encode($value, $options);
    }

    #endregion

    /**
     * @inheritDoc
     */
    public function toArray() {
        $attributes = parent::toArray();

        foreach ($attributes as &$attribute) {
            if ($attribute instanceof Carbon)
                $attribute = $attribute->setTimezone(config('app.timezone'))->toDateString();
        }

        return $attributes;
    }
}
