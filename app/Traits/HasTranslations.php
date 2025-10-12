<?php

namespace App\Traits;

use App\Models\Translation;

trait HasTranslations
{
    protected $tempTranslations = [];

    public function getAppends()
    {
        $appends = parent::getAppends();

        if (property_exists($this, 'translatableFields') && is_array($this->translatableFields)) {
            $appends = array_merge($appends, $this->translatableFields);
        }

        return $appends;
    }

    public function translationsField()
    {
        return $this->hasMany(Translation::class, 'record_id')
            ->where('table_name', $this->getTable());
    }

    /**
     * الوصول إلى القيم المترجمة ديناميكيًا
     */
    public function __get($key)
    {
        // التحقق من suffix اللغة (مثال: title_en)
        foreach ($this->translatableFields as $field) {
            if (str_starts_with($key, $field)) {
                $locale = null;
                // تحقق هل المستخدم وضع suffix
                if (preg_match('/^' . $field . '_(\w{2})$/', $key, $matches)) {
                    $locale = $matches[1];
                }
                return $this->translateField($field, $locale);
            }
        }

        return parent::__get($key);
    }

    /**
     * تعيين قيمة مترجمة ديناميكيًا
     */
    public function __set($key, $value)
    {
        foreach ($this->translatableFields as $field) {
            if (str_starts_with($key, $field)) {
                $locale = null;
                if (preg_match('/^' . $field . '_(\w{2})$/', $key, $matches)) {
                    $locale = $matches[1];
                }
                $this->updateTranslations([$field => $value], $locale);
                return;
            }
        }

        parent::__set($key, $value);
    }

    public function translateField($field, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        if (!in_array($field, $this->translatableFields)) return null;

        $translation = $this->translationsField()
        ->where('field', $field)
        ->where('locale', $locale)
        ->first();

        return $translation ? $translation->value : null;
    }

    public function updateTranslations(array $data, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        foreach ($data as $field => $value) {
            if (!in_array($field, $this->translatableFields)) continue;
            Translation::updateOrCreate(
                [
                    'table_name' => $this->getTable(),
                    'record_id'  => $this->id,
                    'field'      => $field,
                    'locale'     => $locale,
                ],
                ['value' => $value]
            );
        }
    }

    public function setTranslations(array $translations)
    {
        if (!property_exists($this, 'translatableFields') || empty($this->translatableFields)) {
            return $this;
        }
        $allowedTranslations = [];
        foreach ($translations as $field => $locales) {
            if (in_array($field, $this->translatableFields)) {
                $allowedTranslations[$field] = $locales;
            }
        }
        $this->tempTranslations = $allowedTranslations;
        return $this;
    }

    public static function bootHasTranslations()
    {
        static::deleting(function ($model) {
            $model->translationsField()->delete();
        });

        static::created(function ($model) {
            if (!empty($model->tempTranslations)) {
                foreach ($model->tempTranslations as $field => $locales) {
                    foreach ($locales as $locale => $value) {
                        $model->updateTranslations([$field => $value], $locale);
                    }
                }
                $model->tempTranslations = [];
            }
        });
    }


    public function scopeWithTranslations($query, $fields = [], $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        if (is_string($locale)) $locale = [$locale];
        $table = $query->getModel()->getTable();

        return $query->with(['translationsField' => function ($q) use ($fields, $locale, $table) {
            $q->whereIn('locale', $locale)
                ->where('table_name', $table);

            if (!empty($fields)) {
                $allowed = array_intersect($fields, $this->translatableFields);
                $q->whereIn('field', $allowed);
            }
        }]);
    }
}
