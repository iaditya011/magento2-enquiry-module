<?php

namespace Tcz\Enquiry\Model\Resolver;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Tcz\Enquiry\Model\Enquiry;
use Psr\Log\LoggerInterface;

class CreateEnquiry implements ResolverInterface
{
    private $enquiry;
    private $logger;

    /**
     * Constructor
     *
     * @param Enquiry $enquiryFactory
     * @param LoggerInterface $logger
     */
    public function __construct(Enquiry $enquiry, LoggerInterface $logger)
    {
        $this->enquiry = $enquiry;
        $this->logger = $logger;
    }

    /**
     * Resolver to create a new enquiry.
     *
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param null|array $value
     * @param null|array $args
     * @return array
     * @throws GraphQlInputException
     * @throws LocalizedException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        ?array $value = null,
        ?array $args = null
    ): array {
        
        // Log the received arguments for debugging
        $this->logger->info('Received arguments for createEnquiryy:', ['args' => $args]);

        // Validate input
        if (!isset($args['input']['name'], $args['input']['email'], $args['input']['phone'], $args['input']['message'])) {
            throw new GraphQlInputException(phrase: __('All fields are required.'));
        }
        try {
            // Create Enquiryy instance
            $enquiry = $this->enquiry;

            // Set the data to the Enquiryy model
            $enquiry->setData([
                'name' => $args['input']['name'],
                'email' => $args['input']['email'],
                'phone_no'      => $args['input']['phone'],
                'phone' => $args['input']['phone'],
                'message' => $args['input']['message'], // Correct field name
                'enquiry_type'  => $args['input']['enquiry_type'],
                'status' => 'pending', // Default status
                'created_at' => date('Y-m-d H:i:s'), // Current timestamp
            ]);

            // Save the data to the database
            $enquiry->save();

            // Log successful saving
            $this->logger->info('Enquiry saved successfully with ID: ' . $enquiry->getId());

            // Return success response
            return [
                'success' => true,
                'message' => 'Enquiry created successfully.',
            ];
        } catch (\Exception $e) {
            // Log exception details for debugging
            $this->logger->error('Error creating enquiry: ' . $e->getMessage());

            // Catch any exception and return an error message
            throw new LocalizedException(__('Unable to create enquiry. Error: ' . $e->getMessage()));
        }
    }
}
