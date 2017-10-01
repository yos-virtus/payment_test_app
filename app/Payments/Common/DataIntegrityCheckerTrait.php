<?php 

namespace App\Payments\Common;

trait DataIntegrityCheckerTrait
{
    protected function checkDataForIntegrity($data)
    {
        foreach ($this->validProviderDataKeys as $key) {
            if (! array_key_exists($key, $data)) {

                throw new \Exception("Отсутствуют необходимые данные для проведения операции");
            }
        }
        return true;
    }
}