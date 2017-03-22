<?php

namespace CreaQCM\QCMBundle\Form;

use CreaQCM\QCMBundle\Entity\Qcm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QcmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'label' => 'Nom du QCM:'
        ));
        $builder->add('questions', CollectionType::class, array(
            'entry_type' => QuestionType::class,
            'allow_add'    => true,
            'by_reference' => false,
            'allow_delete' => true,
        ));
		$builder->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Qcm::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'crea_qcmqcmbundle_qcm_type';
    }
}
