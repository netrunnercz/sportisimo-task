<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


abstract class SecuredPresenter extends Nette\Application\UI\Presenter
{
    public function startup(): void
    {
        parent::startup();

        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }

}
