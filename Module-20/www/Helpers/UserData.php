<?php

namespace Helpers;

class UserData
{
    /**
     * @param array $incomingData
     * @return array|null
     */
    public function trimedData(array $incomingData): array|null
    {
        if (empty($incomingData)) return null;

        foreach ($incomingData as $key => $value) {
            if (is_string($value)) {
                $incomingData[$key] = trim($value);
            } elseif (is_array($value)) {
                $incomingData[$key] = $this->trimedData($value);
            }
        }
        return $incomingData;
    }
}
