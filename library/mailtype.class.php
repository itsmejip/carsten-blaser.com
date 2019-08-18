<?php 
namespace Jip\Library;

class MailType {
    /**
     * System email (not able to opt out)
     */
    const SYSTEM = 1;
    /**
     * Advert email
     */
    const ADVERT = 2;
    /**
     * Newsletter email
     */
    const NEWSLETTER = 3;
    /**
     * Updates
     */
    const UPDATES = 4;
}

?>