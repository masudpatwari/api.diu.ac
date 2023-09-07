<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use App\Models\STD\Book;
use App\Models\STD\Question;
use Exception;
use Illuminate\Console\Command;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class CourseMaterialCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "importCourseMaterial";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "import Course Material to New std system";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // convert json to array
        $array = json_decode(file_get_contents(storage_path('products.json')), true);

        //  create a new collection instance from the array
        $products = collect($array);


        $this->comment("No. Products : " . $products->count());

        $type = [];
        $bookArray = [];
        $questionArray = [];

        foreach ($products as $product) {


//            $this->info(  $product['id'] . ' ' .
//                $product['name']  . ' ' .
//                $product['slug']  . ' ' .
//                $product['status']. ' ' .
//                $product['featured'] . ' ' .
//                $product['description'] . ' ' .
//                $product['short_description'] . ' '
//            );
//            continue;

            $regex='|href="([^"]+)"[^>]|';
            $howmany = preg_match_all($regex,$product['short_description'],$res,PREG_SET_ORDER);
            $url = @$res[0][1];

            if ( ! $url ){
                continue;
            }
            $fileExtension = strtolower(last(explode(".", $url)));

            if (strtolower($fileExtension )!= 'pdf') {
                continue;
            }



            $categories = collect( $product['categories'] )->pluck('name')->toArray();
            $type =array_merge( $type, $categories);

            if( in_array('QUESTIONS', $categories) ){
                if (($key = array_search('QUESTIONS', $categories)) !== false) {
                    unset($categories[$key]);
                    if (isset($categories[0]) && is_numeric(substr($categories[0], 0, 1)))
                    {
                        $semester = $categories[0];
                        $department = $categories[1]?? null;
                    }

                    if (isset($categories[1]) && is_numeric(substr($categories[1], 0, 1)))
                    {
                        $semester = $categories[1];
                        $department = $categories[0]?? null;
                    }


                    //  url:        https://students.diu.ac/wp-content/uploads/2019/06/DIU_0009.pdf
                    //  filepath:    /usr/share/nginx/html/students.diu.ac/public_html/wp-content/uploads/2019/06/DIU_0009.pdf
                    //  destination: /usr/share/nginx/html/api/core/storage/educationMaterial


                    $filePath = str_replace(['https://students.diu.ac/', 'http://students.diu.ac/'],'/usr/share/nginx/html/students.diu.ac/public_html/',$url);

                    $fileNameId = (count($questionArray)+1);

                    if (file_exists($filePath ))
                    {
                        copy($filePath ,'/usr/share/nginx/html/api/core/storage/educationMaterial/Question_' .  $fileNameId . '.pdf');
                    }

                    $questionArray[] = [
                        'id'=> $fileNameId,
                        'course_name' => $product['name'],
                        'course_code' => '',
                        'department' => $department,
                        'semester' => (int)$semester,
                        'published' => true,
                        'session' => '',
                        'description' => $product['name'],
                    ];

                    $this->info(" Q: ". "semester: " . (int) $semester . ', dept: '. $department);

                }
            }
            elseif (in_array('BOOK', $categories) ){
                if (($key = array_search('BOOK', $categories)) !== false) {
                    unset($categories[$key]);

                    if (isset($categories[0]) && is_numeric(substr($categories[0], 0, 1)))
                    {
                        $semester = $categories[0];
                        $department = $categories[1]?? null;
                    }

                    if (isset($categories[1]) && is_numeric(substr($categories[1], 0, 1)))
                    {
                        $semester = $categories[1];
                        $department = $categories[0]?? null;
                    }


                    //  url:        https://students.diu.ac/wp-content/uploads/2019/06/DIU_0009.pdf
                    //  filepath:    /usr/share/nginx/html/students.diu.ac/public_html/wp-content/uploads/2019/06/DIU_0009.pdf
                    //  destination: /usr/share/nginx/html/api/core/storage/educationMaterial


                    $filePath = str_replace(['https://students.diu.ac/', 'http://students.diu.ac/'],'/usr/share/nginx/html/students.diu.ac/public_html/',$url);

                    $fileNameId = (count($bookArray)+1);

                    if (file_exists($filePath ))
                    {
                        copy($filePath ,'/usr/share/nginx/html/api/core/storage/educationMaterial/Book_' .  $fileNameId . '.pdf');
                    }

                    $bookArray[] = [
                        'id'=> $fileNameId,
                        'publisher_name' =>'',
                        'edition' => '',
                        'no_of_pages'=>0,
                        'feature' => '0',
                        'name' => $product['name'],
                        'department' => $department,
                        'semester' => (int)$semester,
                        'published' => true,
                        'description' => $product['name'],
                        'short_description'=> $product['name'],
                    ];


//                    $this->info(  $product['id'] . ' ' .
//                        $product['name']  . ' ' .
//                        $product['slug']  . ' ' .
//                        $product['status']. ' ' .
//                        $product['featured'] . ' ' .
//                        $product['description'] . ' ' .
//                        $product['short_description'] . ' '
//                    );
//                    var_dump($categories);
                    $this->info(" B: "."semester: " . (int)$semester . ', dept: '. $department);

                }
            }else{

            }



            continue;

        }



        Question::insert($questionArray);
        Book::insert($bookArray);
        dump( count($questionArray), count($bookArray) );


        try {

            $this->info("All products have been visited");
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
    }
}
