<?php

namespace App\Observers;

use App\Category;

class CategoryObserver
{
    /**
     * Handle the category "created" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        if (is_null($category->position)) {
            $category->position = Category::max('position') + 1;
            return;
        }

        $lowerPriorityCategories = Category::where('position', '>=', $category->position)->get();

        foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
            $lowerPriorityCategory->position++;
            $lowerPriorityCategory->saveQuietly();
        }
    }

    /**
     * Handle the category "updated" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        if ($category->isClean('position')) {
            return;
        }

        if (is_null($category->position)) {
            $category->position = Category::max('position');
        }

        if ($category->getOriginal('position') > $category->position) {
            $positionRange = [
                $category->position, $category->getOriginal('position')
            ];
        } else {
            $positionRange = [
                $category->getOriginal('position'), $category->position
            ];
        }

        $lowerPriorityCategories = Category::where('id', '!=', $category->id)
            ->whereBetween('position', $positionRange)
            ->get();

        foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
            if ($category->getOriginal('position') < $category->position) {
                $lowerPriorityCategory->position--;
            } else {
                $lowerPriorityCategory->position++;
            }
            $lowerPriorityCategory->saveQuietly();
        }
    }

    /**
     * Handle the category "deleted" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        $lowerPriorityCategories = Category::where('position', '>', $category->position)->get();

        foreach ($lowerPriorityCategories as $lowerPriorityCategory) {
            $lowerPriorityCategory->position--;
            $lowerPriorityCategory->saveQuietly();
        }
    }

    /**
     * Handle the category "restored" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
