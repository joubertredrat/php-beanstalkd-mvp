<?php
/*
 * php app.php
 */
$loader = require_once __DIR__ . "/../vendor/autoload.php";
$loader->add('Acme', __DIR__);

use Qutee\Queue;
use Qutee\Task;
use Qutee\Worker;

$beanstalkdParams    = array(
    'host'  => '127.0.0.1',
    'port'  => 11300
);

$queuePersistor = new Qutee\Persistor\Beanstalk();
$queuePersistor->setOptions($beanstalkdParams);

$queue          = new Qutee\Queue();
$queue->setPersistor($queuePersistor);

// Create a task
$task = new Task;
$task
    ->setName('Acme/SendMail')
    ->setData(array(
        'to'        => 'someone@somewhere.com',
        'from'      => 'qutee@nowhere.tld',
        'subject'   => 'Hi!',
        'text'      => 'It\'s your faithful QuTee!'
    ))
    ->setPriority(Task::PRIORITY_HIGH)
    ->setUniqueId('send_mail_email@domain.tld');

// Queue it
$queue->addTask($task);

// Or do this in one go, if you set the queue (bootstrap maybe?)
Task::create(
    'Acme/SendMail',
    array(
        'to'        => 'someone@somewhere.com',
        'from'      => 'qutee@nowhere.tld',
        'subject'   => 'Hi!',
        'text'      => 'It\'s your faithful QuTee!'
    ),
    Task::PRIORITY_HIGH
);

// Send worker to do it
$worker = new Worker;
$worker
    ->setQueue($queue)
    ->setPriority(Task::PRIORITY_HIGH);

while (true) {
    try {
        if (null !== ($task = $worker->run())) {
            echo 'Ran task: '. $task->getName() . PHP_EOL;
        }
    } catch (Exception $e) {
        echo 'Error: '. $e->getMessage() . PHP_EOL;
    }
}
    