<?php

interface RepositoryInterface {
    public function findall(): array;
    public function findById(int $id);
    public function update($user): bool;
    public function delete($user): bool;
}

?>
