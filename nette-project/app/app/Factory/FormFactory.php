<?php

use Nette\Application\UI\Form;
use Nette\Database\Table\Selection;

class MyFormFactory{

    public function __construct(

    ){}

    public function create(): Form{
        $form = new Form;
        return $form;
    }
}


class SignInFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}
    
    public function create(): Form{
        $form = $this->MyFormFactory->create();
        $form->addText('email', 'email')->setRequired();
        $form->addPassword('password', 'password')->setRequired();
        $form->addSubmit('send', 'send');
        return $form;
    }

}

class RegisterFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}
    
    public function create(): Form{
        $form = $this->MyFormFactory->create();
        $form->addText('firstname', 'Jméno')->setRequired();
        $form->addText('lastname', 'Příjmení')->setRequired();
        $form->addText('email', 'email')->setRequired();
        $form->addPassword('password', 'password')->setRequired();
        $form->addPassword('password2', 'password again')->setRequired();
        $form->addInteger('group_id', 'grupa');
        $form->addSubmit('send', 'send');
        return $form;
    }

}

class GroupFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}
    
    public function create(): Form{
        $form = $this->MyFormFactory->create();
        $form->addText('name', 'Jméno skupiny')->setRequired();
        $form->addSubmit('send', 'Create');
        return $form;
    }

}

class GroupDeleteFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}
    

    public function create(Selection $items): Form{
        $array = $items->fetchAll();
        $arrayNames = [];
        foreach ($array as $d) {
            array_push($arrayNames, $d->offsetGet('name'));
        }
        $form = $this->MyFormFactory->create();
        $form->addSelect('selected', 'Položky k odstranění', $arrayNames)->getSelectedItem();
        $form->addSubmit('delete', 'delete');
        return $form;
    }
}

class TableFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}

    public function create(): Form{
        $form = $this->MyFormFactory->create();
        $form->addSubmit('send', 'Create');
        return $form;
    }
}


class TableDeleteFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}
    

    public function create(Selection $items): Form{
        $array = $items->fetchAll();
        $arrayNames = [];
        foreach ($array as $d) {
            array_push($arrayNames, $d->offsetGet('id'));
        }
        $form = $this->MyFormFactory->create();
        $form->addSelect('selected', 'Položky k odstranění', $arrayNames)->getSelectedItem();
        $form->addSubmit('delete', 'delete');
        return $form;
    }
}

