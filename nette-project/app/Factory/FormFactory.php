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
        private Nette\Database\Explorer $database,
    ){}
    
    public function create(): Form{
        $groups = $this->database->table('groups')->fetchPairs('id', 'name');
        $form = $this->MyFormFactory->create();
        $form->addText('firstname', 'Jméno')->setRequired();
        $form->addText('lastname', 'Příjmení')->setRequired();
        $form->addText('email', 'email')->setRequired();
        $form->addPassword('password', 'password')->setRequired();
        $form->addPassword('password2', 'password again')->setRequired();
        $form->addSelect('group_id', 'grupa', $groups)->setRequired();
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
        $tableArray = $items->fetchAll();
        $arrayNames = array();
        foreach ($tableArray as $d) {
            $arrayNames += [$d->id => $d->id];
        }
        $form = $this->MyFormFactory->create();
        $form->addSelect('selected', 'Položky k odstranění', $arrayNames)->getSelectedItem();
        $form->addInteger('selectedOrder', 'order ID');
        $form->addSubmit('delete', 'delete');
        return $form;
    }
}

#########################################ORDERS##############################################


class OrderFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}

    public function create(): Form{
        $form = $this->MyFormFactory->create();
        $form->addSelect('selectedFood', 'vybrane jidlo')->getSelectedItem();
        $form->addSelect('selectedTable', 'stul')->getSelectedItem();
        $form->addSubmit('send', 'Create');
        return $form;
    }
}

class OrderDeleteFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}

    public function create(): Form{
        $form = $this->MyFormFactory->create();
        $form->addSelect('selectedOrder', 'objednavka')->getSelectedItem();
        $form->addSubmit('delete', 'Create');
        return $form;
    }
}

class OrderChangeFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}

    public function create(): Form{
        $status = ['pending', 'delivered', 'paid', 'closed'];
        $form = $this->MyFormFactory->create();
        $form->addSelect('selectedOrder', 'objednavka')->getSelectedItem();
        $form->addSelect('selectedStatus', 'status', $status)->getSelectedItem();
        $form->addSubmit('change', 'Change');
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

    public function createDelete(): Form{
        $form = $this->MyFormFactory->create();
        $form->addSubmit('send', 'Create');
        return $form;
    }
}



#########################################PRICES##############################################


class PriceFormFactory{
    public function __construct(
        private MyFormFactory $MyFormFactory,
    ){}

    public function create(): Form{
        $form = $this->MyFormFactory->create();
        $form->addSelect('selectedFood', 'vybrane jidlo');
        $form->addInteger('price', 'cena')->setRequired(true);
        $form->addSubmit('send', 'CHANGE');
        return $form;
    }
}