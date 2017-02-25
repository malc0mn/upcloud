<?php

namespace UpCloud\Entity;

final class FirewallRule extends AbstractEntity
{
    /**
     * Action to take if the rule conditions are met.
     *
     * @var string accept|reject|drop
     */
    public $action;

    /**
     * Freeform comment string for the rule.
     *
     * @var string
     */
    public $comment;

    /**
     * The destination address range ends to this address.
     *
     * @var string Valid IP address
     */
    public $destinationAddressEnd;

    /**
     * The destination address range starts from this address.
     *
     * @var string Valid IP address
     */
    public $destinationAddressStart;

    /**
     * The destination port range starts from this port number.
     *
     * @var string 1-65535
     */
    public $destinationPortEnd;

    /**
     * The destination port range starts from this port number.
     *
     * @var string 1-65535
     */
    public $destinationPortStart;

    /**
     * The direction of network traffic this rule will be applied to.
     *
     * @var string in|out
     */
    public $direction;

    /**
     * If protocol is set the address family of new firewall rule.
     *
     * @var string IPv4|IPv6
     */
    public $family;

    /**
     * The ICMP type.
     *
     * @var string 0-255
     */
    public $icmpType;

    /**
     * Add the firewall rule to this position in the server's firewall list.
     *
     * @var string 1-1000
     */
    public $position;

    /**
     * The protocol this rule will be applied to.
     *
     * @var string tcp|udp|icmp
     */
    public $protocol;

    /**
     * The source address range ends to this address.
     *
     * @var string Valid IP address
     */
    public $sourceAddressEnd;

    /**
     * The source address range starts from this address.
     *
     * @var string Valid IP address
     */
    public $sourceAddressStart;

    /**
     * The source port range ends to this port number.
     *
     * @var string 1-65535
     */
    public $sourcePortEnd;

    /**
     * The source port range starts from this port number.
     *
     * @var string 1-65535
     */
    public $sourcePortStart;
}
