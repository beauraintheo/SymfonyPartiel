<?php

namespace App\Form;

use App\Entity\Memo;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('memo_text', TextareaType::class, [
                'label' => 'Contenu du mémo',
                'required' => true,
                'attr' => [
                    'class' => 'input-text',
                    'rows' => 10,
                    'cols' => 100
                ]
            ])
            ->add('memo_delay', IntegerType::class, [
                'label' => 'Delai d\'expiration (en minutes)',
                'required' => true,
                'attr' => [
                    'class' => 'input-p',
                    'min' => 1,
                    'max' => 180,
                    'notInRangeMessage' => "La durée d'expiration doit être comprise entre 1 et 180 min"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Memo::class,
        ]);
    }
}
