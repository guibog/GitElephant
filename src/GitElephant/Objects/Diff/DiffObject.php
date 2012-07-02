 * @package GitElephant\Objects\Diff
 *
    const MODE_RENAMED      = 'renamed_file';
    /**
     * the cursor position
     *
     * @var int
     */

    /**
     * the original file path for the diff object
     *
     * @var string
     */

    /**
     * the destination path for the diff object
     *
     * @var string
     */

    /**
     * rename similarity index
     *
     * @var int
     */
    private $similarityIndex;

    /**
     * the diff mode
     *
     * @var string
     */

    /**
     * the diff chunks
     *
     * @var array
     */

        $sliceIndex = 4;
        if ($this->hasPathChanged()) {
            $this->findSimilarityIndex($lines[1]);
            if (isset($lines[4]) && !empty($lines[4])) {
                $this->findMode($lines[4]);
                $sliceIndex = 7;
            } else {
                $this->mode = self::MODE_RENAMED;
            }
        } else {
            $this->findMode($lines[1]);
        }
            $lines = array_slice($lines, $sliceIndex);
    /**
     * look for similarity index in the line
     *
     * @param string $line line content
     */
    private function findSimilarityIndex($line)
    {
        $matches = array();
        if (preg_match('/^similarity index (.*)\%$/', $line, $matches)) {
            $this->similarityIndex = $matches[1];
        }
    }

    /**
     * Check if path has changed (file was renamed)
     *
     * @return bool
     */
    public function hasPathChanged()
    {
        return ($this->originalPath !== $this->destinationPath);
    }

    /**
     * Get similarity index
     *
     * @return int
     * @throws \RuntimeException if not a rename
     */
    public function getSimilarityIndex()
    {
        if ($this->hasPathChanged()) {
            return $this->similarityIndex;
        }

        throw new \RuntimeException('Cannot get similiarity index on non-renames');
    }