<?php

namespace App\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class ObservableBelongsToMany extends BelongsToMany {

    /**
     * Uma camada que possibilita observables serem ativados em tabelas pivot.
     * Para que a classe funcione, é necessário indicar a model da tabela pivot
     * com o método 'using' (eg. new ObservableBelongsToMany(...)->using('App\MinhaRelacao')).
     * 
     * @param query A query do objeto que deseja obter (eg. se na classe User ele possui vários Projects, Project::query())
     * @param parent O objeto que está chamando o método (eg. $this)
     * @param table O nome da tabela pivot da relação
     * @param foreignPivotKey Na tabela pivot, qual coluna se refere ao $this
     * @param relatedPivotKey Na tabela pivot, qual coluna se refere ao objeto que queremos obter
     * @param parentKey Na tabela de $this, sua chave primária (eg. 'id')
     * @param relatedKey Na tabela do objeto que deseja obter, sua chave primária (eg. 'id')
     * @param relationName Algum nome para a relação
     */
    public function __construct($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName) {
        parent::__construct(
            $query,
            $parent,
            $table,
            $foreignPivotKey,
            $relatedPivotKey,
            $parentKey,
            $relatedKey,
            $relationName
        );
    }

    public function save(Model $model, array $pivotAttributes = [], $touch = true) {
        $classParent = get_class($this->parent);
        $classModel = get_class($model);

        // Ordenar alfabeticamente os argumentos para o evento
        if (strcmp($classParent, $classModel) < 0) {
            $args = [
                $this->parent,
                $model,
            ];
        } else {
            $args = [
                $model,
                $this->parent,
            ];
        };

        event("eloquent.creating: $this->using", $args);
        $res = parent::save($model, $pivotAttributes, $touch);
        event("eloquent.created: $this->using", $args);

        return $res;
    }

    /**
     * Remove a relation
     * You must pass a Model instace (or array of models)
     * 
     */
    public function detach($ids = null, $touch = true) {

        if (!($ids instanceof Model)) {
            throw new \Exception('Uma ObservableRelation precisa de uma Model como argumento para detach');
        }

        $classParent = get_class($this->parent);
        $classModel = get_class($ids);

        // Ordenar alfabeticamente os argumentos para o evento
        if (strcmp($classParent, $classModel) < 0) {
            $args = [
                $this->parent,
                $ids,
            ];
        } else {
            $args = [
                $ids,
                $this->parent,
            ];
        };

        event("eloquent.deleting: $this->using", $args);
        parent::detach($ids, $touch);
        event("eloquent.deleted: $this->using", $args);
    }
}