<?php

namespace App\Contracts;

interface RepositoryInterface
{
    /**
     * Select all records from a table.
     */
    public function findAll(): array;

    /**
     * Select a record by its ID.
     */
    public function find(int $id): ?object;

    /**
     * Insert a new record.
     */
    public function save(object $entity): void;

    /**
     * Update an existing record.
     */
    public function update(object $entity): void;

    /**
     * Delete a record by its ID.
     */
    public function delete(int $id): void;
}
