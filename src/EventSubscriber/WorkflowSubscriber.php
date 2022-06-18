<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Workflow\Event\Event;
use Psr\Log\LoggerInterface;

class WorkflowSubscriber implements EventSubscriberInterface
{

    public function __construct(private MailerInterface $mailer, private LoggerInterface $logger)
    {}

    public function newToyRequest(Event $event)
    {

        $this->logger->info('Envoi de mail nouveau jouet -------');

        $email = (new Email())
            ->from($event->getSubject()->getFamilyMember()->getEmail())
            ->to('dad@test.com')
            ->addTo('mum@test.com')
            ->subject('Demande de jouet - ' . $event->getSubject()->getName())
            ->text('Bonjour Maman et Papa, merci de me commander le jouet : ' . $event->getSubject()->getName());

        $this->mailer->send($email);
    }

    public function toyReceived(Event $event)
    {
        $email = (new Email())
            ->from('papa.noel@laponie.fr')
            ->to($event->getSubject()->getFamilyMember()->getEmail())
            ->subject('Ton jouet est la, oh oh oh !')
            ->text('Ton jouet est arrivé, amuse toi bien !');

        $this->mailer->send($email);
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.toy_request.leave.request' => 'newToyRequest',
            'workflow.toy_request.entered.received' => 'toyReceived',
        ];
    }
}
