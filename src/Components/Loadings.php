<?php
namespace Rolice\Econt\Components;

final class Loadings implements ComponentInterface
{

    protected $rows = [];

    public function add(Row $load)
    {
        $this->rows[] = $load;
    }

    public function serialize()
    {
        $result = [];

        foreach($this->rows as $load) {
            $result[] = $load->serialize();
        }

        return $result;
    }

}