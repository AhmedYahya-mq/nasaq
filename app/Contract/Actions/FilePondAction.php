<?php 
namespace App\Contract\Actions;

interface FilePondAction
{
    public function process($request);
    public function revert($request);
    public function restore(string $id);
    public function remove($request);
    public function moveToPublic(array|string $filenames, string $destinationFolder = 'uploads'): array;
}