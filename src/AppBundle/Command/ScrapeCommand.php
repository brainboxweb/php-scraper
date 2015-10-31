<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\Helper\Scraper;
use Goutte\Client;

//php app/console bb:scrape 'http://www.sainsburys.co.uk/webapp/wcs/stores/servlet/CategoryDisplay?listView=true&orderBy=FAVOURITES_FIRST&parent_category_rn=12518&top_category=12518&langId=44&beginIndex=0&pageSize=20&catalogId=10137&searchTerm=&categoryId=185749&listId=&storeId=10151&promotionId=#langId=44&storeId=10151&catalogId=10137&categoryId=185749&parent_category_rn=12518&top_category=12518&pageSize=20&orderBy=FAVOURITES_FIRST&searchTerm=&beginIndex=0&hideFilters=true'

class ScrapeCommand extends Command {
    protected function configure() {
        $this
            ->setName('bb:scrape')
            ->setDescription('Scrape a web page')
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'Page to scrape'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $output->writeln('');
        $output->writeln('-----------STARTING------------');
        $output->writeln('');

        $url = $input->getArgument('url');


        $client = new Client;
        $scraper = new Scraper($client);

        $result =  $scraper->getJson($url);

        $output->writeln('');
        $output->writeln('');
        if($result) {
            $output->writeln($result);
        } else {
            $output->writeln('Oops: something went wrong :(');
        }

        $output->writeln('');
        $output->writeln('-----------FINISHED------------');
        $output->writeln('');    }
}
