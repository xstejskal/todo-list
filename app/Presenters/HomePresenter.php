<?php

declare(strict_types=1);

namespace App\Presenters;

use Dibi\DateTime;
use Model\Entity\Issue;
use Model\Entity\Tag;
use Model\Repository\IssueRepository;
use Model\Repository\TagRepository;
use Nette\DI\Attributes\Inject;
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;


final class HomePresenter extends Presenter
{

    private ?Issue $issue = null;

    private array $tags = [];

    #[Inject]
    public IssueRepository $issueRepository;

    #[Inject]
    public TagRepository $tagRepository;

    public function actionDefault(?int $id): void
    {
        // dostupne tagy
        $this->tags = $this->tagRepository->findAll();

        if ($id) {
            $this->issue = $this->issueRepository->find($id);

            if (empty($this->issue)) {
                $this->error('Issue not found');
            }
        }
    }

    public function renderDefault(): void
    {
        $this->template->issues = $this->issueRepository->findAll();
    }

    public function handleDone(): noreturn
    {
        if (empty($this->issue)) {
            $this->error('Issue not found');
        }

        $this->issue->done = true;
        $this->issueRepository->persist($this->issue);

        $this->redirect('Home:');
    }

    public function handleRemove(): noreturn
    {
        if (empty($this->issue)) {
            $this->error('Issue not found');
        }

        $this->issue->deleted = new DateTime();
        $this->issueRepository->persist($this->issue);

        $this->redirect('Home:');
    }

    /**
     * Ukladani issues
     */
    protected function createComponentIssueForm(): Form
    {
        $form = new Form();

        $form->addHidden('id', $this->issue?->id);

        $form->addText('title', 'Title:')
            ->setRequired('Please enter a title.');

        $form->addTextarea('content', 'Content:');

        $form->addMultiSelect('tags', 'Tags:', array_combine(array_column($this->tags, 'id'), array_column($this->tags, 'name')));

        $form->addCheckbox('done', 'Done');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = fn (Form $form) => $this->issueFormSucceeded($form->getValues());

        if ($this->issue) {
            $defaults = $this->issue->getRowData();
            $defaults['tags'] = array_column($this->issue->tags, 'id');
            $form->setDefaults($defaults);
        }

        return $form;
    }


    private function issueFormSucceeded(iterable $values): noreturn
    {
        if ($this->issue) {
            $this->flashMessage('The issue has been updated.');
        } else {
            $this->issue = new Issue();
            $this->flashMessage('The issue has been added.');
        }

        $this->issue->title = $values->title;
        $this->issue->content = $values->content;
        $this->issue->done = (bool) $values->done;

        // nastavime tagy az po vytvoreni issue
        if ($this->issue->isDetached()) {
            $this->issueRepository->persist($this->issue);
        }

        if (empty($values['tags'])) {
            $this->issue->removeAllTags();
        } else {
            $this->issue->replaceAllTags($values->tags);
        }

        $this->issueRepository->persist($this->issue);

        $this->redirect('Home:');
    }

    /**
     * Ukladani tagu
     */
    protected function createComponentTagForm(): Form
    {
        $form = new Form();

        $form->addText('name', 'Name:')
            ->setRequired('Please enter a name.');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = fn(Form $form) => $this->tagFormSucceeded($form->getValues());

        return $form;
    }


    private function tagFormSucceeded(iterable $values): noreturn
    {
        $tag = new Tag();
        $this->flashMessage('The tag has been added.');

        $tag->assign($values);
        $this->tagRepository->persist($tag);

        $this->redirect('Home:');
    }


}
