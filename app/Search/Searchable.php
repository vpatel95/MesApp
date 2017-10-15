<?php

namespace App\Search;

trait Searchable
{
    
    public static function bootSearchable() {

        if (config('services.search.enabled')) {
            static::observe(app(ElasticsearchObserver::class));
        }

    }

    public function getSearchIndex() {

        return $this->getTable();

    }

    public function getSearchType() {

        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray() {

        return $this->toArray();
    
    }

}