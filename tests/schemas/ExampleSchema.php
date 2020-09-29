<?php
use Dry\DryStruct;

class ExampleSchema extends DryStruct
{
    public function __construct()
    {
        parent::__construct();
        $this->required('name')->filled('string');
        $this->optional('age')->filled('integer')->min(6);
        $this->requiredObject('book')->do(
            function ($book) {
                $book->required('title')->filled('string');
            }
        );
        $this->requiredArray('buyers')->each(
            function ($buyer) {
                $buyer->type('object')->do(
                    function ($buyer) {
                        $buyer->required('name')->filled('string');
                    }
                );
            }
        );
    }
}
