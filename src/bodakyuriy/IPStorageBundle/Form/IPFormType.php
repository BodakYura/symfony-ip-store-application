<?php
/**
 * Created by PhpStorm.
 * User: yuriybodak
 * Date: 15.10.18
 * Time: 14:02
 */

namespace bodakyuriy\IPStorageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class IPFormType
 * @package IPStorageBundle\Form
 */
class IPFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $action = $options['action'];

        $builder
            ->setAction($action)
            ->setMethod('POST')
            ->add('ip', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('add', SubmitType::class, [
                'label' => 'Submit'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => null,
                'csrf_protection' => true,
                'csrf_token_id'   => 'ip_form_token',
                'required' => false,

            ]
        );
    }

    /**
     * @return null|string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}