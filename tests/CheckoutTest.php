<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Checkout.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $user = 'root';
    $password = 'root';
    $DB = new PDO($server, $user, $password);

    class CheckoutTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Checkout::deleteSome('all');
        }

        function test_Checkout_get_set_construct()
        {
            // Arrange
            $checkout1 = new Checkout(1, 3, '2017-03-07', '2017-03-21', '', 'testing', 1, 923);

            // Act
            $checkout2 = new Checkout(2, 4, '2017-03-08', '2017-03-22', '2017-03-10', 'testing2', 0, 924);
            $checkout2->setBookCopyId($checkout1->getBookCopyId());
            $checkout2->setPatronId($checkout1->getPatronId());
            $checkout2->setCheckoutDate($checkout1->getCheckoutDate());
            $checkout2->setDueDate($checkout1->getDueDate());
            $checkout2->setReturnedDate($checkout1->getReturnedDate());
            $checkout2->setComment($checkout1->getComment());
            $checkout2->setStillOut($checkout1->getStillOut());
            $checkout2->setId($checkout1->getId());

            // Assert
            $this->assertEquals(
                [1, 3, '2017-03-07', '2017-03-21', '', 'testing', 1, 923],
                [$checkout2->getBookCopyId(),
                $checkout2->getPatronId(),
                $checkout2->getCheckoutDate(),
                $checkout2->getDueDate(),
                $checkout2->getReturnedDate(),
                $checkout2->getComment(),
                $checkout2->getStillOut(),
                $checkout2->getId()]
            );
        }

        function test_Checkout_save_deleteSome_all_getSome_all()
        {
            // Arrange
            $checkout1 = new Checkout(1, 3, '2017-03-07', '2017-03-21', '', 'testing', 1, 923);
            $checkout2 = new Checkout(2, 4, '2017-03-08', '2017-03-22', '2017-03-10', 'testing2', 0, 924);

            // Act
            $checkout1->save();
            $checkout2->save();

            Checkout::deleteSome('all');

            $checkout3 = new Checkout(3, 5, '2017-03-09', '2017-03-23', '2017-03-11', 'testing3', 0, 925);
            $checkout4 = new Checkout(4, 6, '2017-03-10', '2017-03-24', '2017-03-12', 'testing4', 0, 926);
            $checkout3->save();
            $checkout4->save();

            // Assert
            $this->assertEquals(
                [$checkout3, $checkout4],
                Checkout::getSome('all')
            );
        }
    }
?>
