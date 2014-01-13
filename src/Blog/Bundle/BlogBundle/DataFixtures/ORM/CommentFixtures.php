<?php

namespace Blog\Bundle\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Blog\Bundle\BlogBundle\Entity\Post;
use Blog\Bundle\BlogBundle\Entity\Comment;

class CommentFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $commentOne = new Comment();
        $commentOne->setUser('Apuleius')
            ->setComment('Vt ferme religiosis viantium moris est, cum aliqui lucus aut aliqui
                        locus sanctus in via oblatus est, votum postulare, pomum adponere, paulisper
                        adsidere: ita mihi ingresso sanctissimam istam civitatem, quamquam oppido
                        festinem, praefanda venia et habenda oratio et inhibenda properatio est.
                        Neque enim iustius religiosam moram viatori obiecerit aut ara floribus
                        redimita aut spelunca frondibus inumbrata aut quercus cornibus onerata aut
                        fagus pellibus coronata, vel enim colliculus saepimine consecratus vel
                        truncus dolamine effigiatus vel cespes libamine umigatus vel lapis unguine
                        delibutus. Parva haec quippe et quamquam paucis percontantibus adorata,
                        tamen ignorantibus transcursa.')
//            ->setCreatedAt(new \DateTime('2014-02-04 13:13'))
//            ->setApproved(true)
            ->setPost($manager->merge($this->getReference('postOne')));

        $manager->persist($commentOne);

        $commentTwo = new Comment();
        $commentTwo->setUser('Gaius Iulius Caesar')
            ->setComment('Gallia est omnis divisa in partes tres, quarum unam incolunt Belgae,
                           aliam Aquitani, tertiam qui ipsorum lingua Celtae, nostra Galli appellantur.
                           Hi omnes lingua, institutis, legibus inter se differunt. Gallos ab Aquitanis
                           Garumna flumen, a Belgis Matrona et Sequana dividit. Horum omnium fortissimi
                           sunt Belgae, propterea quod a cultu atque humanitate provinciae longissime absunt,
                           minimeque ad eos mercatores saepe commeant atque ea quae ad effeminandos animos pertinent
                           important, proximique sunt Germanis, qui trans Rhenum incolunt, quibuscum continenter
                           bellum gerunt.')
//            ->setCreatedAt(new \DateTime('2014-02-01 17:13'))
//            ->setApproved(true)
            ->setPost($manager->merge($this->getReference('postTwo')));

        $manager->persist($commentTwo);

        $commentThree = new Comment();
        $commentThree->setUser('Gaius Iulius Caesar')
            ->setComment('Gallia est omnis divisa in partes tres, quarum unam incolunt Belgae,
                           aliam Aquitani, tertiam qui ipsorum lingua Celtae, nostra Galli appellantur.
                           Hi omnes lingua, institutis, legibus inter se differunt. Gallos ab Aquitanis
                           Garumna flumen, a Belgis Matrona et Sequana dividit. Horum omnium fortissimi
                           sunt Belgae, propterea quod a cultu atque humanitate provinciae longissime absunt,
                           minimeque ad eos mercatores saepe commeant atque ea quae ad effeminandos animos pertinent
                           important, proximique sunt Germanis, qui trans Rhenum incolunt, quibuscum continenter
                           bellum gerunt.')
//            ->setCreatedAt(new \DateTime('2014-02-08 16:13'))
//            ->setApproved(true)
            ->setPost($manager->merge($this->getReference('postTwo')));

        $manager->persist($commentThree);

        $commentFour = new Comment();
        $commentFour->setUser('Apuleius')
            ->setComment('Vt ferme religiosis viantium moris est, cum aliqui lucus aut aliqui
                        locus sanctus in via oblatus est, votum postulare, pomum adponere, paulisper
                        adsidere: ita mihi ingresso sanctissimam istam civitatem, quamquam oppido
                        festinem, praefanda venia et habenda oratio et inhibenda properatio est.
                        Neque enim iustius religiosam moram viatori obiecerit aut ara floribus
                        redimita aut spelunca frondibus inumbrata aut quercus cornibus onerata aut
                        fagus pellibus coronata, vel enim colliculus saepimine consecratus vel
                        truncus dolamine effigiatus vel cespes libamine umigatus vel lapis unguine
                        delibutus. Parva haec quippe et quamquam paucis percontantibus adorata,
                        tamen ignorantibus transcursa.')
//            ->setCreatedAt(new \DateTime('2014-02-01 17:13'))
//            ->setApproved(true)
            ->setPost($manager->merge($this->getReference('postThree')));

        $manager->persist($commentFour);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

} 