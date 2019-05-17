<?php


namespace bluekachina\langui;


define('DEFAULT_PATH_TO_LANG' , resource_path('lang')) ;
/**
 * Class langui
 * @package bluekachina\langui
 */
class langui
{
    /**
     * @var
     */
    private $path;
    private $files;
    private $languages;
    public $lang;

    /**
     * @return mixed
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param mixed $languages
     */
    public function setLanguages($languages): void
    {
        $this->languages = $languages;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files ?? array();
    }

    /**
     * @param mixed $all_language_files
     * @return langui
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path_to_language_files
     * @return langui
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * langui constructor.
     */
    public function __construct($path = null)
    {
        $this->setPath($path ?? DEFAULT_PATH_TO_LANG);
        $this->setLanguages($this->getLanguageAbbreviations());
        $this->identifyFilesInThisFolder();
        $this->assembleMasterLangObject();
    }

    /**
     * @param $path
     * @return array
     */
    private function getDirContents($path = null) {
        $path = $path ?? $this->getPath();
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        $files = array();
        foreach ($rii as $file)
            if (!$file->isDir())
                $files[] = $file->getPathname();

        return $files;
    }

    private function getLanguageAbbreviations($path = null){
        $languages = array();
        $path = $path ?? $this->getPath();
        //Make sure the path we're using has a trailing \*
        $trailing_wildcard = "\\*";

        file_put_contents('c:/temp/phplog.txt', var_export($path, true));

        $path = substr($path,(strlen($trailing_wildcard) * -1)) == $trailing_wildcard ? $path : $path . $trailing_wildcard;

        $iterator = new \DirectoryIterator(dirname($path));
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $languages[] = $fileinfo->getFilename() ;
            }
        }
        return $languages;
    }

    private function identifyFilesInThisFolder($path = null){
        //Use the path that was passed in as a parameter, fall back to the default path if param was not provided
        $path = $path ?? $this->getPath();
        //Grab a listing of all of the language content files in this folder
        $all_files_found = $this->getDirContents($path);
        $all_files_found = array_map(
            function($path_to_file){
                return substr($path_to_file, strrpos($path_to_file, '\\') + 1);
            },
            $all_files_found);
        //Find out which of those file names are new (haven't been discovered in other language folders yet)
        $distinct_files =
            array_filter(
                $all_files_found,
                function($this_file){
                    return !in_array($this_file,$this->getFiles());
                });
        //Add any file names we haven't already seen into this instance's private member
        $this->setFiles(array_merge($this->getFiles(),$distinct_files));
    }

    private function assembleMasterLangObject(){
        $this->lang = array();
        foreach ($this->getLanguages() as $language){
            $this->lang[$language] = $this->getFiles();
        }
    }
}