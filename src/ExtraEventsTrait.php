<?php

namespace NeylsonGularte\EloquentExtraEvents;


// Trait for models
trait ExtraEventsTrait
{
    /**
     * Define a many-to-many relationship.
     *
     * @param  string  $related
     * @param  string  $table
     * @param  string  $foreignPivotKey
     * @param  string  $relatedPivotKey
     * @param  string  $parentKey
     * @param  string  $relatedKey
     * @param  string  $relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function belongsToMany($related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null,
                                  $parentKey = null, $relatedKey = null, $relation = null)
    {
        $belongsToMany = parent::belongsToMany($related, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relation);

        $query    = $belongsToMany->getQuery()->getModel()->newQuery();
        $parent   = $belongsToMany->getParent();
        $table    = $belongsToMany->getTable();
        $instance = $this->newRelatedInstance($related);

        $foreignPivotKey   = explode('.', $belongsToMany->getQualifiedForeignPivotKeyName())[1];
        $relatedPivotKey   = explode('.', $belongsToMany->getQualifiedRelatedPivotKeyName())[1];
        $relation = $belongsToMany->getRelationName();

        return new BelongsToMany($query, $parent, $table, $foreignPivotKey, $relatedPivotKey,
            $parentKey ?: $this->getKeyName(), $relatedKey ?: $instance->getKeyName(), $relation);
    }
}
