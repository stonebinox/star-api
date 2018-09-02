<?php

/**
 * Class file for managing response messages.
 * @author Anoop Santhanam
 */
class messageManager
{
    
    /**
     * Method to generate an error message
     * @param string The message to be generated
     * 
     * @return array The response array.
     */
    public function error(string $message): array
    {
        return ["error" => $message];
    }

    /**
     * Method to generate a normal message.
     * @param string The message to be generated
     * 
     * @return The response array.
     */
    public function info(string $message): array
    {
        return ["info" => $message];
    }
}
