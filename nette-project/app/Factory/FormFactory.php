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

#########################################SIGN IN##############################################

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
#########################################REGISTER##############################################

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

#########################################GROUPS##############################################
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

#########################################TABLES##############################################

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

#########################################ORDERS##############################################


class OrderFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}

    public function create(Selection $foodItems, Selection $tables): Form{
        $tableArray = $tables->fetchAll();
        $foodArray = $foodItems->fetchAll();
        $foodNames = [];
        $tableIds = [];
        foreach ($foodArray as $d) {
            array_push($foodNames, $d->offsetGet('name'));
        }
        foreach($tableArray as $d) {
            array_push($tableIds, $d->offsetGet('id'));
        }
        $form = $this->MyFormFactory->create();
        $form->addSelect('selectedFood', 'vybrane jidlo', $foodNames)->getSelectedItem();
        $form->addSelect('selectedTable', 'stul', $tableIds)->getSelectedItem();
        $form->addSubmit('send', 'Create');
        return $form;
    }
}

#########################################FOOD##############################################



class FoodFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}

    public function create(): Form{
        $form = $this->MyFormFactory->create();
        $form->addText('name', 'Název pokrmu')->setRequired(true);
        $form->addInteger('quantity', 'Počet jídla')->setRequired(true);
        $form->addInteger('price', 'cena')->setRequired(true);
        $form->addUpload('image', 'Obrázek jídla')->addRule(Form::Image, 'Image must be JPEG, PNG or BMP')->addRule(Form::MaxFileSize, 'Max size of file is 2 MB', 2 * 1024 * 1024);
        $form->addSubmit('send', 'Create');
        return $form;
    }
}


#########################################PRICES##############################################


class PriceFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}

    public function create(Selection $foodItems): Form{
        $foodArray = $foodItems->fetchAll();
        $foodNames = [];
        foreach ($foodArray as $d) {
            array_push($foodNames, $d->offsetGet('name'));
        }
        $form = $this->MyFormFactory->create();
        $form->addSelect('selectedFood', 'vybrane jidlo', $foodNames)->getSelectedItem();
        $form->addInteger('price', 'cena')->setRequired(true);
        $form->addSubmit('send', 'CHANGE');
        return $form;
    }
}