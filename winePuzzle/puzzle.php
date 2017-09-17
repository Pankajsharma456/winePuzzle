<?php
/**
 * puzzle.php is writtern in PHP and has script whcih provides the result for the project of 'wine sold by vineyards of Apan'.
 *
 * 
 * Class Puzzle has a function which runs "person_wine_3.txt" file and retun a file which contain desired output.
 *
 * PHP version 5.5.X
 */
class Puzzle{
	/**
     * Class Puzzle
     *
     * Input is file name 
     *
     * @var $fileName
     */
	public $fileName;

	function __construct($input){
		$this->fileName = $input;
	}

	/**
     * function soldWines
     *
     * input is file which contains the person and wine data, output is a TSV file which provides desired outcome based on puzzle.
     *
     */
	public function soldWines(){
		$Wishlist	= array();
		$wineList 	= array();
		$wineSold 	= 0;
		$finalListing  = array();
		$file 	= fopen($this->fileName,"r");
		while (($line = fgets($file)) !== false) {
			$PersonWine = explode("\t", $line);
			$name = trim($PersonWine[0]);
			$wine = trim($PersonWine[1]);
			if(!array_key_exists($wine, $Wishlist)){
				$Wishlist[$wine] = array();
			}
			$Wishlist[$wine][] = $name;
			$wineList[] = $wine;
		}
		fclose($file);
		$wineList = array_unique($wineList);
		foreach ($wineList as $key => $wine) {
			$maxSize = count($wine);
			$counter = 0;

			while($counter < 10){
				$i = intval(floatval(rand()/(float)getrandmax()) * $maxSize);
				$person = $Wishlist[$wine][$i];
				if(!array_key_exists($person, $finalListing)){
					$finalListing[$person] = array();
				}
				if(count($finalListing[$person]) < 3){
					$finalListing[$person][] = $wine;
					$wineSold++;
					break;
				}
				$counter++;
			}
		}

		$fh = fopen("AssignmentOutput.txt", "w");
		fwrite($fh, "Total number of wine bottles sold by Apan : ".$wineSold."\n");
		foreach (array_keys($finalListing) as $key => $person) {
			foreach ($finalListing[$person] as $key => $wine) {
				fwrite($fh, $person." ".$wine."\n");
			}
		}
		fclose($fh);
	}
}
$puzzle = new Puzzle("person_wine_3.txt");
$puzzle->soldWines();
echo "Prcocessing has beed done. Desried output has been written in AssignmentOutput.txt file";
?>
