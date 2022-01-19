<?php
namespace App\Form;

use App\Entity\Enquiry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'Имя']);
        $builder->add('email', EmailType::class, ['label' => 'Электронный адрес']);
        $builder->add('subject', TextType::class, ['label' => 'Тема']);
        $builder->add('body', TextareaType::class, ['label' => 'Сообщение']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'contact';
    }
}