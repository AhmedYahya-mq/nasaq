<?php

namespace App\Traits;

use App\Models\Translation;
use Illuminate\Contracts\Container\BindingResolutionException;

trait HasTranslations
{

    public function getAppends()
    {
        $appends = parent::getAppends();

        if (property_exists($this, 'translatableFields') && is_array($this->translatableFields)) {
            $appends = array_merge($appends, $this->translatableFields);
        }

        return $appends;
    }

    /**
     * العلاقة مع جدول الترجمات
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translationsField()
    {
        return $this->hasMany(Translation::class, 'record_id')
            ->where('table_name', $this->getTable());
    }

    /**
     * جلب الترجمة لحقل معين ولغة معينة
     * @param string $field اسم الحقل المترجم
     * @param string|null $locale اللغة المطلوبة (افتراضيًا لغة التطبيق)
     * @return string|null القيمة المترجمة أو null إذا لم توجد
     */
    public function translateField($field, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        if (!in_array($field, $this->translatableFields)) {
            return null;
        }
        $translation = $this->translationsField
            ->where('field', $field)
            ->where('locale', $locale)
            ->first();

        return $translation ? $translation->value : null;
    }


    /**
     * تحميل الترجمات مع النموذج
     * @param mixed $query
     * @param array $fields الأعمدة المترجمة للتحميل (افتراضيًا كل الأعمدة)
     * @param string|array|null $locale اللغة المطلوبة (افتراضيًا لغة التطبيق)
     * @return mixed
     * @throws BindingResolutionException
     */
    public function scopeWithTranslations($query, $fields = [], $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        if (is_string($locale)) {
            $locale = [$locale];
        }
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

    /**
     * تحديث أو إنشاء الترجمات
     * @param array $data
     * @param mixed $locale
     * @return void
     * @throws BindingResolutionException
     */
    public function updateTranslations(array $data, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        foreach ($data as $field => $value) {
            if (!in_array($field, $this->translatableFields)) {
                continue;
            }
            Translation::updateOrCreate(
                [
                    'table_name' => $this->getTable(),
                    'record_id'  => $this->id,
                    'field'      => $field,
                    'locale'     => $locale,
                ],
                [
                    'value' => $value,
                ]
            );
        }
    }

    /**
     * جلب القيمة المترجمة عند الوصول إلى خاصية النموذج
     * @param string $key
     * @return mixed
     * @throws BindingResolutionException
     */
    public function __get($key)
    {
        $translated = $this->translateField($key);
        if ($translated !== null) {
            return $translated;
        }
        return parent::__get($key);
    }


    /**
     * Scope بحث مرن على الأعمدة المترجمة
     * - إذا $fields فارغة، يبحث على كل الأعمدة المترجمة
     * - يدعم أي لغة، مع fallback
     * @param mixed $query
     * @param string $term مصطلح البحث
     * @param array $fields الأعمدة المترجمة للبحث فيها (افتراضيًا كل الأعمدة)
     * @param string|null $locale اللغة المطلوبة (افتراضيًا لغة التطبيق)
     * @return mixed
     * @throws BindingResolutionException
     */
    public function scopeSearch($query, string $term, array $fields = [], $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $table = $query->getModel()->getTable();

        if (!empty($fields)) {
            $fields = array_intersect($fields, $this->translatableFields);
            if (empty($fields)) return $query;
        }

        return $query->whereHas('translationsField', function ($q) use ($fields, $term, $locale, $table) {
            $q->where('table_name', $table)
                ->where(function ($subQ) use ($fields, $term, $locale, $table) {
                    if (empty($fields)) {
                        $subQ->where('locale', $locale)
                            ->where('value', 'like', "%{$term}%");
                    } else {
                        foreach ($fields as $field) {
                            $subQ->orWhere(function ($sq) use ($field, $term, $locale) {
                                $sq->where('field', $field)
                                    ->where('locale', $locale)
                                    ->where('value', 'like', "%{$term}%");
                            });
                        }
                    }
                });
        });
    }

    /**
     * حذف الترجمة لحقل أو أكثر
     *
     * @param string|array $fields اسم الحقل أو مصفوفة من الحقول
     * @param string|null $locale اللغة المطلوبة (افتراضيًا لغة التطبيق)
     * @return void
     */
    public function deleteTranslations($fields, $locale = null): void
    {
        $locale = $locale ?: app()->getLocale();
        $fields = is_array($fields) ? $fields : [$fields];

        Translation::where('table_name', $this->getTable())
            ->where('record_id', $this->id)
            ->whereIn('field', $fields)
            ->when($locale, function ($q) use ($locale) {
                $q->where('locale', $locale);
            })
            ->delete();
    }

    /**
     * حذف جميع الترجمات المرتبطة بالنموذج
     *
     * @return void
     */
    public function clearTranslations(): void
    {
        Translation::where('table_name', $this->getTable())
            ->where('record_id', $this->id)
            ->delete();
    }
}
