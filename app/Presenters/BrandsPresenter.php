<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\BrandsRepository;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Nette\InvalidStateException;

final class BrandsPresenter extends SecuredPresenter
{
    public function __construct(
		private BrandsRepository $brands,
	) {
	}

	protected function createComponentEditBrandForm() : Form
	{
		$form = new Form;
		$form->addText('name', 'Název:')
			->setRequired('Název musí být vyplněn.');
		$form->addText('description', 'Popis:');
		$form->addText('brandId');
		$form->addSubmit('send', 'Odeslat');
		$form->onSuccess[] = [$this, 'editBrandFormSucceeded'];
		return $form;
	}

	public function editBrandFormSucceeded(Form $form, $data) : void
	{
		//some validation and other magic necessary in real life app
		
		//I don't understand this. For some reason nettes draw hidden field even if it's drawed manually. Therefore this ugly stuff...
		if(isset($data["brandId"][0]))
		{
			$data["id"] = $data["brandId"][0];
		}

		try {
			$this->brands->insertOrUpdate($data);
			$this->flashMessage('Záznam pro značku ' . $data['name'] . ' byl uložen.');
		} catch (UniqueConstraintViolationException $e) {
            $this->flashMessage('Nelze vložit záznam, značka s názvem ' . $data['name'] . ' již existuje.', 'error');
        } catch (InvalidStateException $e) {
			$this->flashMessage('Nelze upravit záznam, značka s ID ' . $data['id'] . ' neexistuje.', 'error');
		}
		//some logging and custom exceptions in real life app on failures

		$this->redirect('Brands:');
	}

	public function renderDefault(int $page = 1, int $itemsPerPage = 3, int $asc = 1) : void
	{
		$brands = $this->brands->listBrands($asc);

		$numOfPages = 0;
		$this->template->pages = ceil($brands->count() / $itemsPerPage);
		$this->template->brands = $brands->page($page, $itemsPerPage, $numOfPages);
		$this->template->page = $page;
		$this->template->itemsPerPage = $itemsPerPage;
		$this->template->asc = $asc;
	}

	public function handleGetBrandData(int $brandId) : void
	{
		if($this->isAjax())
		{
			$this->template->formData = $this->brands->getById($brandId);
			$this->redrawControl('editBrandForm');
		}
	}

	public function actionDelete(int $id) : void
	{
		//some validation and other magic in real life app

		$this->brands->delete($id);
		$this->flashMessage('Záznam smazán.');
		$this->redirect('Brands:');
	}
}
