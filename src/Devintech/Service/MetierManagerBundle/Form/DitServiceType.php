<?php

namespace App\Devintech\Service\MetierManagerBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DitServiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('srvLabel', TextType::class, array(
                'label'    => "Libellé",
                'required' => true
            ))

            ->add('srvDesc', TextareaType::class, array(
                'label'    => "Description",
                'required' => false
            ))

            ->add('srvPrix', TextType::class, array(
                'label'    => "Prix (en €)",
                'attr'     => array('pattern' => "[0-9]+([,\.][0-9]+)?"),
                'required' => false
            ))

            ->add('srvReduction', TextType::class, array(
                'label'    => "Réduction",
                'attr'     => array('pattern' => "[0-9]+([,\.][0-9]+)?"),
                'required' => true
            ))

            ->add('ditServiceType', EntityType::class, array(
                'label'         => 'Type',
                'class'         => 'App\Devintech\Service\MetierManagerBundle\Entity\DitServiceType',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('st')
                        ->orderBy('st.srvTpLabel', 'ASC');
                },
                'choice_label'  => 'srvTpLabel',
                'multiple'      => false,
                'expanded'      => false,
                'required'      => true,
                'placeholder'   => '- Séléctionner Type -'
            ))

            ->add('ditServiceOptions', EntityType::class, array(
                'label'         => 'Option(s) service',
                'class'         => 'App\Devintech\Service\MetierManagerBundle\Entity\DitServiceOption',
                'query_builder' => function (EntityRepository $_er) {
                    return $_er
                        ->createQueryBuilder('so')
                        ->orderBy('so.ditServiceOptionType', 'ASC');
                },
                'choice_label'  => 'serviceOptionString',
                'multiple'      => true,
                'required'      => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Devintech\Service\MetierManagerBundle\Entity\DitService'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'dit_service_metiermanagerbundle_service';
    }
}
