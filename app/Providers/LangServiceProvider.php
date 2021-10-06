<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

class LangServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        /**
         *
         * translate field(s) from Collection(more than model)
         *
         */
        Collection::macro('CollectionTranslate', function ($arr,$lang) {
            Collection::transform(function ($item) use($arr,$lang){
                foreach ($arr as $value) {
                    $item_return = $lang . '_' . $value;
                    $item->{$value} = $item->{$item_return};
                }
                return $item;
            });
         });

        /**
         *
         * translate field(s) from Relation(more than model)
         *
         */

        Collection::macro('RelationTranslate', function ($arr,$lang,$relationName) {
            Collection::transform(function ($item) use($arr,$lang,$relationName){
                foreach ($arr as $return_column) {
                    $column = $lang . '_' . $return_column;
                    if ($relationName &&$item->{$relationName} !=null ){
                        $item->{$relationName}->transform(function ($item)use($arr,$lang,$relationName,$return_column,$column){
                            $item->{$return_column}=$item->{$column};
                            return $item;
                        });
                    }
                }
                return $item;
            });
        });


        Collection::macro('RelationTranslateForOneToOne', function ($arr,$lang,$relationName) {
            Collection::transform(function ($item) use($arr,$lang,$relationName){
                foreach ($arr as $return_column) {
                    $column = $lang . '_' . $return_column;
                    if ($relationName && $item->{$relationName} !=null){
                        $item->{$relationName}->{$return_column}=$item->{$relationName}->{$column};
                    }
                }
                return $item;
            });
        });

        Collection::macro('RelationTranslateForOneToOneInRelation', function ($arr,$lang,$relationName,$child_relation) {
            Collection::transform(function ($item) use($arr,$lang,$relationName,$child_relation){
                foreach ($arr as $return_column) {
                    $column = $lang . '_' . $return_column;
                    if ($relationName && $item->{$relationName} !=null){
                        $item->{$relationName}->transform(function ($item)use($arr,$lang,$relationName,$child_relation,$return_column,$column){
                            if (!is_null($item->{$child_relation})) {
                                $item->{$child_relation}->{$return_column} = $item->{$child_relation}->{$column};
                                return $item;
                            }
                        });
                    }
                }
                return $item;
            });

        });





    }//end fun
}//end class
