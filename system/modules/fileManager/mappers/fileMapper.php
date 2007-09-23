<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('fileManager/file');

/**
 * fileMapper: ������
 *
 * @package modules
 * @subpackage fileManager
 * @version 0.1.4
 */

class fileMapper extends simpleMapper
{
    /**
     * ��� ������
     *
     * @var string
     */
    protected $name = 'fileManager';

    /**
     * ��� ������ DataObject
     *
     * @var string
     */
    protected $className = 'file';

    /**
     * ��������� ����� �������� �� �������������� �����
     *
     * @param integer $id ������������� �����
     * @return array
     */
    public function searchByFolder($folder_id)
    {
        return $this->searchAllByField('folder_id', (int)$folder_id);
    }

    public function searchById($id)
    {
        return $this->searchOneByField('id', $id);
    }

    public function getExclusionExtensions()
    {
        return array('tar.gz', 'tar.bz2');
    }

    public function searchByPath($path)
    {
        $path = urldecode($path);

        if (strpos($path, '/') !== false) {
            $folderName = substr($path, 0, strrpos($path, '/'));
            $pagename = substr(strrchr($path, '/'), 1);

            $toolkit = systemToolkit::getInstance();
            $folderMapper = $toolkit->getMapper('fileManager', 'folder', $this->section);

            $folder = $folderMapper->searchByPath($folderName);

            if (!is_null($folder)) {
                $criteria = new criteria();
                $criteria->add('name', $pagename)->add('folder_id', $folder->getId());
                return $this->searchOneByCriteria($criteria);
            }
        }

        return null;
    }

    /**
     * ����������� ����� �� ����� �����
     *
     * @param string $mask ����� ��� LIKE
     */
    public function searchByNameMask($mask)
    {
        $criterion = new criterion('name', $mask, criteria::LIKE);
        $criteria = new criteria();
        $criteria->add($criterion);
        $criteria->setOrderByFieldAsc('name');
        return $this->searchAllByCriteria($criteria);
    }

    /**
     * ���������� �������� � �������� $fields ����� ����������� � ��
     *
     * @param array $fields
     */
    protected function updateDataModify(&$fields)
    {
        if (isset($fields['name']) && !isset($fields['ext'])) {
            $fields['ext'] = '';
            if (($dot = strrpos($fields['name'], '.')) !== false) {
                $fields['ext'] = strtolower(substr($fields['name'], $dot + 1));
            }
        }

        $fields['modified'] = new sqlFunction('UNIX_TIMESTAMP');
    }

    public function delete(file $file)
    {
        $id = $file->getId();

        if ($file->extra() instanceof fmSimpleFile) {
            $file->extra()->delete();
        }

        if ($file && file_exists($file = $file->getUploadPath() . DIRECTORY_SEPARATOR . $file->getRealname())) {
            unlink($file);
        }

        parent::delete($id);
    }

    /**
     * ���������� �������� � �������� $fields ����� �������� � ��
     *
     * @param array $fields
     */
    protected function insertDataModify(&$fields)
    {
        $this->updateDataModify($fields);
    }

    public function convertArgsToObj($args)
    {
        if (isset($args['id']) && !isset($args['name'])) {
            $args['name'] = $args['id'];
        }

        $file = $this->searchByPath($args['name']);

        if (!isset($file)) {
            $file = $this->searchOneByField('name', $args['name']);
        }
        if ($file) {
            return $file;
        }

        throw new mzzDONotFoundException();
    }

    public function get404()
    {
        return new messageController('������������� ���� ���� �� ������', messageController::WARNING);
        //fileLoader::load('fileManager/controllers/fileManager404Controller');
        //return new fileManager404Controller('file');
    }

    public function getMimetypes()
    {
        return array(
        '3ds'           => 'image/x-3ds',
        'BLEND'         => 'application/x-blender',
        'C'             => 'text/x-c++src',
        'CSSL'          => 'text/css',
        'NSV'           => 'video/x-nsv',
        'PAR2'          => 'application/x-par2',
        'XM'            => 'audio/x-mod',
        'Z'             => 'application/x-compress',
        'a'             => 'application/x-archive',
        'abw'           => 'application/x-abiword',
        'abw.CRASHED'   => 'application/x-abiword',
        'abw.gz'        => 'application/x-abiword',
        'ac3'           => 'audio/ac3',
        'adb'           => 'text/x-adasrc',
        'ads'           => 'text/x-adasrc',
        'afm'           => 'application/x-font-afm',
        'ag'            => 'image/x-applix-graphics',
        'ai'            => 'application/illustrator',
        'aif'           => 'audio/x-aiff',
        'aifc'          => 'audio/x-aiff',
        'aiff'          => 'audio/x-aiff',
        'al'            => 'application/x-perl',
        'arj'           => 'application/x-arj',
        'as'            => 'application/x-applix-spreadsheet',
        'asc'           => 'text/plain',
        'asf'           => 'video/x-ms-asf',
        'asp'           => 'application/x-asp',
        'asx'           => 'video/x-ms-asf',
        'atom'          => 'application/atom+xml',
        'au'            => 'audio/basic',
        'avi'           => 'video/x-msvideo',
        'aw'            => 'application/x-applix-word',
        'bak'           => 'application/x-trash',
        'bcpio'         => 'application/x-bcpio',
        'bdf'           => 'application/x-font-bdf',
        'bib'           => 'text/x-bibtex',
        'bin'           => 'application/octet-stream',
        'blend'         => 'application/x-blender',
        'blender'       => 'application/x-blender',
        'bmp'           => 'image/bmp',
        'bz'            => 'application/x-bzip',
        'bz2'           => 'application/x-bzip',
        'c'             => 'text/x-csrc',
        'c++'           => 'text/x-c++src',
        'cc'            => 'text/x-c++src',
        'cdf'           => 'application/x-netcdf',
        'cdr'           => 'application/vnd.corel-draw',
        'cer'           => 'application/x-x509-ca-cert',
        'cert'          => 'application/x-x509-ca-cert',
        'cgi'           => 'application/x-cgi',
        'cgm'           => 'image/cgm',
        'chm'           => 'application/x-chm',
        'chrt'          => 'application/x-kchart',
        'class'         => 'application/x-java',
        'cls'           => 'text/x-tex',
        'cpio'          => 'application/x-cpio',
        'cpio.gz'       => 'application/x-cpio-compressed',
        'cpp'           => 'text/x-c++src',
        'cpt'           => 'application/mac-compactpro',
        'crt'           => 'application/x-x509-ca-cert',
        'cs'            => 'text/x-csharp',
        'csh'           => 'application/x-csh',
        'css'           => 'text/css',
        'csv'           => 'text/x-comma-separated-values',
        'cur'           => 'image/x-win-bitmap',
        'cxx'           => 'text/x-c++src',
        'd'             => 'text/x-dsrc',
        'dat'           => 'video/mpeg',
        'dbf'           => 'application/x-dbase',
        'dc'            => 'application/x-dc-rom',
        'dcl'           => 'text/x-dcl',
        'dcm'           => 'application/dicom',
        'dcr'           => 'application/x-director',
        'deb'           => 'application/x-deb',
        'der'           => 'application/x-x509-ca-cert',
        'desktop'       => 'application/x-desktop',
        'dia'           => 'application/x-dia-diagram',
        'diff'          => 'text/x-patch',
        'dir'           => 'application/x-director',
        'djv'           => 'image/vnd.djvu',
        'djvu'          => 'image/vnd.djvu',
        'dll'           => 'application/octet-stream',
        'dmg'           => 'application/octet-stream',
        'dms'           => 'application/octet-stream',
        'doc'           => 'application/msword',
        'dsl'           => 'text/x-dsl',
        'dtd'           => 'text/x-dtd',
        'dvi'           => 'application/x-dvi',
        'dwg'           => 'image/vnd.dwg',
        'dxf'           => 'image/vnd.dxf',
        'dxr'           => 'application/x-director',
        'egon'          => 'application/x-egon',
        'el'            => 'text/x-emacs-lisp',
        'eps'           => 'image/x-eps',
        'epsf'          => 'image/x-eps',
        'epsi'          => 'image/x-eps',
        'etheme'        => 'application/x-e-theme',
        'etx'           => 'text/x-setext',
        'exe'           => 'application/x-ms-dos-executable',
        'ez'            => 'application/andrew-inset',
        'f'             => 'text/x-fortran',
        'fig'           => 'image/x-xfig',
        'fits'          => 'image/x-fits',
        'flac'          => 'audio/x-flac',
        'flc'           => 'video/x-flic',
        'fli'           => 'video/x-flic',
        'flw'           => 'application/x-kivio',
        'fo'            => 'text/x-xslfo',
        'g3'            => 'image/fax-g3',
        'gb'            => 'application/x-gameboy-rom',
        'gcrd'          => 'text/directory',
        'gen'           => 'application/x-genesis-rom',
        'gg'            => 'application/x-sms-rom',
        'gif'           => 'image/gif',
        'glade'         => 'application/x-glade',
        'gmo'           => 'application/x-gettext-translation',
        'gnc'           => 'application/x-gnucash',
        'gnucash'       => 'application/x-gnucash',
        'gnumeric'      => 'application/x-gnumeric',
        'gra'           => 'application/x-graphite',
        'gram'          => 'application/srgs',
        'grxml'         => 'application/srgs+xml',
        'gsf'           => 'application/x-font-type1',
        'gsm'           => 'audio/x-gsm',
        'gtar'          => 'application/x-gtar',
        'gz'            => 'application/x-gzip',
        'h'             => 'text/x-chdr',
        'h++'           => 'text/x-chdr',
        'hdf'           => 'application/x-hdf',
        'hh'            => 'text/x-c++hdr',
        'hp'            => 'text/x-chdr',
        'hpgl'          => 'application/vnd.hp-hpgl',
        'hqx'           => 'application/mac-binhex40',
        'hs'            => 'text/x-haskell',
        'htm'           => 'text/html',
        'html'          => 'text/html',
        'icb'           => 'image/x-icb',
        'ice'           => 'x-conference/x-cooltalk',
        'ico'           => 'image/x-ico',
        'ics'           => 'text/calendar',
        'idl'           => 'text/x-idl',
        'ief'           => 'image/ief',
        'ifb'           => 'text/calendar',
        'iff'           => 'image/x-iff',
        'iges'          => 'model/iges',
        'igs'           => 'model/iges',
        'ilbm'          => 'image/x-ilbm',
        'iso'           => 'application/x-cd-image',
        'it'            => 'audio/x-it',
        'jar'           => 'application/x-jar',
        'java'          => 'text/x-java',
        'jng'           => 'image/x-jng',
        'jnlp'          => 'application/x-java-jnlp-file',
        'jp2'           => 'image/jpeg2000',
        'jpg'           => 'image/jpeg',
        'jpe'           => 'image/jpeg',
        'jpeg'          => 'image/jpeg',
        'jpr'           => 'application/x-jbuilder-project',
        'jpx'           => 'application/x-jbuilder-project',
        'js'            => 'application/x-javascript',
        'kar'           => 'audio/midi',
        'karbon'        => 'application/x-karbon',
        'kdelnk'        => 'application/x-desktop',
        'kfo'           => 'application/x-kformula',
        'kil'           => 'application/x-killustrator',
        'kon'           => 'application/x-kontour',
        'kpm'           => 'application/x-kpovmodeler',
        'kpr'           => 'application/x-kpresenter',
        'kpt'           => 'application/x-kpresenter',
        'kra'           => 'application/x-krita',
        'ksp'           => 'application/x-kspread',
        'kud'           => 'application/x-kugar',
        'kwd'           => 'application/x-kword',
        'kwt'           => 'application/x-kword',
        'la'            => 'application/x-shared-library-la',
        'latex'         => 'application/x-latex',
        'lha'           => 'application/x-lha',
        'lhs'           => 'text/x-literate-haskell',
        'lhz'           => 'application/x-lhz',
        'log'           => 'text/x-log',
        'ltx'           => 'text/x-tex',
        'lwo'           => 'image/x-lwo',
        'lwob'          => 'image/x-lwo',
        'lws'           => 'image/x-lws',
        'lyx'           => 'application/x-lyx',
        'lzh'           => 'application/x-lha',
        'lzo'           => 'application/x-lzop',
        'm'             => 'text/x-objcsrc',
        'm15'           => 'audio/x-mod',
        'm3u'           => 'audio/x-mpegurl',
        'm4a'           => 'audio/x-m4a',
        'm4u'           => 'video/vnd.mpegurl',
        'man'           => 'application/x-troff-man',
        'mathml'        => 'application/mathml+xml',
        'md'            => 'application/x-genesis-rom',
        'me'            => 'text/x-troff-me',
        'mesh'          => 'model/mesh',
        'mgp'           => 'application/x-magicpoint',
        'mid'           => 'audio/midi',
        'midi'          => 'audio/midi',
        'mif'           => 'application/x-mif',
        'mkv'           => 'application/x-matroska',
        'mm'            => 'text/x-troff-mm',
        'mml'           => 'text/mathml',
        'mng'           => 'video/x-mng',
        'moc'           => 'text/x-moc',
        'mod'           => 'audio/x-mod',
        'moov'          => 'video/quicktime',
        'mov'           => 'video/quicktime',
        'movie'         => 'video/x-sgi-movie',
        'mp2'           => 'video/mpeg',
        'mp3'           => 'audio/mpeg',
        'mpe'           => 'video/mpeg',
        'mpeg'          => 'video/mpeg',
        'mpg'           => 'video/mpeg',
        'mpga'          => 'audio/mpeg',
        'ms'            => 'text/x-troff-ms',
        'msh'           => 'model/mesh',
        'msod'          => 'image/x-msod',
        'msx'           => 'application/x-msx-rom',
        'mtm'           => 'audio/x-mod',
        'mxu'           => 'video/vnd.mpegurl',
        'n64'           => 'application/x-n64-rom',
        'nb'            => 'application/mathematica',
        'nc'            => 'application/x-netcdf',
        'nes'           => 'application/x-nes-rom',
        'nsv'           => 'video/x-nsv',
        'o'             => 'application/x-object',
        'obj'           => 'application/x-tgif',
        'oda'           => 'application/oda',
        'odb'           => 'application/vnd.oasis.opendocument.database',
        'odc'           => 'application/vnd.oasis.opendocument.chart',
        'odf'           => 'application/vnd.oasis.opendocument.formula',
        'odg'           => 'application/vnd.oasis.opendocument.graphics',
        'odi'           => 'application/vnd.oasis.opendocument.image',
        'odm'           => 'application/vnd.oasis.opendocument.text-master',
        'odp'           => 'application/vnd.oasis.opendocument.presentation',
        'ods'           => 'application/vnd.oasis.opendocument.spreadsheet',
        'odt'           => 'application/vnd.oasis.opendocument.text',
        'ogg'           => 'application/ogg',
        'old'           => 'application/x-trash',
        'oleo'          => 'application/x-oleo',
        'oot'           => 'application/vnd.oasis.opendocument.text',
        'otg'           => 'application/vnd.oasis.opendocument.graphics-template',
        'oth'           => 'application/vnd.oasis.opendocument.text-web',
        'otp'           => 'application/vnd.oasis.opendocument.presentation-template',
        'ots'           => 'application/vnd.oasis.opendocument.spreadsheet-template',
        'ott'           => 'application/vnd.oasis.opendocument.text-template',
        'p'             => 'text/x-pascal',
        'p12'           => 'application/x-pkcs12',
        'p7s'           => 'application/pkcs7-signature',
        'par2'          => 'application/x-par2',
        'pas'           => 'text/x-pascal',
        'patch'         => 'text/x-patch',
        'pbm'           => 'image/x-portable-bitmap',
        'pcd'           => 'image/x-photo-cd',
        'pcf'           => 'application/x-font-pcf',
        'pcf.Z'         => 'application/x-font-type1',
        'pcl'           => 'application/vnd.hp-pcl',
        'pdb'           => 'application/vnd.palm',
        'pdf'           => 'application/pdf',
        'pem'           => 'application/x-x509-ca-cert',
        'perl'          => 'application/x-perl',
        'pfa'           => 'application/x-font-type1',
        'pfb'           => 'application/x-font-type1',
        'pfx'           => 'application/x-pkcs12',
        'pgm'           => 'image/x-portable-graymap',
        'pgn'           => 'application/x-chess-pgn',
        'pgp'           => 'application/pgp',
        'php'           => 'application/x-php',
        'php3'          => 'application/x-php',
        'php4'          => 'application/x-php',
        'pict'          => 'image/x-pict',
        'pict1'         => 'image/x-pict',
        'pict2'         => 'image/x-pict',
        'pl'            => 'application/x-perl',
        'pls'           => 'audio/x-scpls',
        'pm'            => 'application/x-perl',
        'png'           => 'image/png',
        'pnm'           => 'image/x-portable-anymap',
        'po'            => 'text/x-gettext-translation',
        'pot'           => 'text/x-gettext-translation-template',
        'ppm'           => 'image/x-portable-pixmap',
        'pps'           => 'application/vnd.ms-powerpoint',
        'ppt'           => 'application/vnd.ms-powerpoint',
        'ppz'           => 'application/vnd.ms-powerpoint',
        'ps'            => 'application/postscript',
        'ps.gz'         => 'application/x-gzpostscript',
        'psd'           => 'image/x-psd',
        'psf'           => 'application/x-font-linux-psf',
        'psid'          => 'audio/prs.sid',
        'pw'            => 'application/x-pw',
        'py'            => 'text/x-python',
        'pyc'           => 'application/x-python-bytecode',
        'pyo'           => 'application/x-python-bytecode',
        'qif'           => 'application/x-qw',
        'qt'            => 'video/quicktime',
        'qtvr'          => 'video/quicktime',
        'ra'            => 'audio/x-pn-realaudio',
        'ram'           => 'audio/x-pn-realaudio',
        'rar'           => 'application/x-rar',
        'ras'           => 'image/x-cmu-raster',
        'rdf'           => 'text/rdf',
        'rej'           => 'application/x-reject',
        'rgb'           => 'image/x-rgb',
        'rle'           => 'image/rle',
        'rm'            => 'audio/x-pn-realaudio',
        'roff'          => 'application/x-troff',
        'rpm'           => 'application/x-rpm',
        'rss'           => 'text/rss',
        'rtf'           => 'application/rtf',
        'rtx'           => 'text/richtext',
        's3m'           => 'audio/x-s3m',
        'sam'           => 'application/x-amipro',
        'scm'           => 'text/x-scheme',
        'sda'           => 'application/vnd.stardivision.draw',
        'sdc'           => 'application/vnd.stardivision.calc',
        'sdd'           => 'application/vnd.stardivision.impress',
        'sdp'           => 'application/vnd.stardivision.impress',
        'sds'           => 'application/vnd.stardivision.chart',
        'sdw'           => 'application/vnd.stardivision.writer',
        'sgi'           => 'image/x-sgi',
        'sgl'           => 'application/vnd.stardivision.writer',
        'sgm'           => 'text/sgml',
        'sgml'          => 'text/sgml',
        'sh'            => 'application/x-shellscript',
        'shar'          => 'application/x-shar',
        'shtml'         => 'text/html',
        'siag'          => 'application/x-siag',
        'sid'           => 'audio/prs.sid',
        'sik'           => 'application/x-trash',
        'silo'          => 'model/mesh',
        'sit'           => 'application/stuffit',
        'skd'           => 'application/x-koan',
        'skm'           => 'application/x-koan',
        'skp'           => 'application/x-koan',
        'skt'           => 'application/x-koan',
        'slk'           => 'text/spreadsheet',
        'smd'           => 'application/vnd.stardivision.mail',
        'smf'           => 'application/vnd.stardivision.math',
        'smi'           => 'application/smil',
        'smil'          => 'application/smil',
        'sml'           => 'application/smil',
        'sms'           => 'application/x-sms-rom',
        'snd'           => 'audio/basic',
        'so'            => 'application/x-sharedlib',
        'spd'           => 'application/x-font-speedo',
        'spl'           => 'application/x-futuresplash',
        'sql'           => 'text/x-sql',
        'src'           => 'application/x-wais-source',
        'stc'           => 'application/vnd.sun.xml.calc.template',
        'std'           => 'application/vnd.sun.xml.draw.template',
        'sti'           => 'application/vnd.sun.xml.impress.template',
        'stm'           => 'audio/x-stm',
        'stw'           => 'application/vnd.sun.xml.writer.template',
        'sty'           => 'text/x-tex',
        'sun'           => 'image/x-sun-raster',
        'sv4cpio'       => 'application/x-sv4cpio',
        'sv4crc'        => 'application/x-sv4crc',
        'svg'           => 'image/svg+xml',
        'swf'           => 'application/x-shockwave-flash',
        'sxc'           => 'application/vnd.sun.xml.calc',
        'sxd'           => 'application/vnd.sun.xml.draw',
        'sxg'           => 'application/vnd.sun.xml.writer.global',
        'sxi'           => 'application/vnd.sun.xml.impress',
        'sxm'           => 'application/vnd.sun.xml.math',
        'sxw'           => 'application/vnd.sun.xml.writer',
        'sylk'          => 'text/spreadsheet',
        't'             => 'application/x-troff',
        'tar'           => 'application/x-tar',
        'tar.Z'         => 'application/x-tarz',
        'tar.bz'        => 'application/x-bzip-compressed-tar',
        'tar.bz2'       => 'application/x-bzip-compressed-tar',
        'tar.gz'        => 'application/x-compressed-tar',
        'tar.lzo'       => 'application/x-tzo',
        'tcl'           => 'text/x-tcl',
        'tex'           => 'text/x-tex',
        'texi'          => 'text/x-texinfo',
        'texinfo'       => 'text/x-texinfo',
        'tga'           => 'image/x-tga',
        'tgz'           => 'application/x-compressed-tar',
        'theme'         => 'application/x-theme',
        'tif'           => 'image/tiff',
        'tiff'          => 'image/tiff',
        'tk'            => 'text/x-tcl',
        'torrent'       => 'application/x-bittorrent',
        'tr'            => 'application/x-troff',
        'ts'            => 'application/x-linguist',
        'tsv'           => 'text/tab-separated-values',
        'ttf'           => 'application/x-font-ttf',
        'txt'           => 'text/plain',
        'tzo'           => 'application/x-tzo',
        'ui'            => 'application/x-designer',
        'uil'           => 'text/x-uil',
        'ult'           => 'audio/x-mod',
        'uni'           => 'audio/x-mod',
        'uri'           => 'text/x-uri',
        'url'           => 'text/x-uri',
        'ustar'         => 'application/x-ustar',
        'vcd'           => 'application/x-cdlink',
        'vcf'           => 'text/directory',
        'vcs'           => 'text/calendar',
        'vct'           => 'text/directory',
        'vfb'           => 'text/calendar',
        'vob'           => 'video/mpeg',
        'voc'           => 'audio/x-voc',
        'vor'           => 'application/vnd.stardivision.writer',
        'vrml'          => 'model/vrml',
        'vsd'           => 'application/vnd.visio',
        'vxml'          => 'application/voicexml+xml',
        'wav'           => 'audio/x-wav',
        'wax'           => 'audio/x-ms-wax',
        'wb1'           => 'application/x-quattropro',
        'wb2'           => 'application/x-quattropro',
        'wb3'           => 'application/x-quattropro',
        'wbmp'          => 'image/vnd.wap.wbmp',
        'wbxml'         => 'application/vnd.wap.wbxml',
        'wk1'           => 'application/vnd.lotus-1-2-3',
        'wk3'           => 'application/vnd.lotus-1-2-3',
        'wk4'           => 'application/vnd.lotus-1-2-3',
        'wks'           => 'application/vnd.lotus-1-2-3',
        'wm'            => 'video/x-ms-wm',
        'wma'           => 'audio/x-ms-wma',
        'wmd'           => 'application/x-ms-wmd',
        'wmf'           => 'image/x-wmf',
        'wml'           => 'text/vnd.wap.wml',
        'wmlc'          => 'application/vnd.wap.wmlc',
        'wmls'          => 'text/vnd.wap.wmlscript',
        'wmlsc'         => 'application/vnd.wap.wmlscriptc',
        'wmv'           => 'video/x-ms-wmv',
        'wmx'           => 'video/x-ms-wmx',
        'wmz'           => 'application/x-ms-wmz',
        'wpd'           => 'application/vnd.wordperfect',
        'wpg'           => 'application/x-wpg',
        'wri'           => 'application/x-mswrite',
        'wrl'           => 'model/vrml',
        'wvx'           => 'video/x-ms-wvx',
        'xac'           => 'application/x-gnucash',
        'xbel'          => 'application/x-xbel',
        'xbm'           => 'image/x-xbitmap',
        'xcf'           => 'image/x-xcf',
        'xcf.bz2'       => 'image/x-compressed-xcf',
        'xcf.gz'        => 'image/x-compressed-xcf',
        'xht'           => 'application/xhtml+xml',
        'xhtml'         => 'application/xhtml+xml',
        'xi'            => 'audio/x-xi',
        'xla'           => 'application/vnd.ms-excel',
        'xlc'           => 'application/vnd.ms-excel',
        'xld'           => 'application/vnd.ms-excel',
        'xll'           => 'application/vnd.ms-excel',
        'xlm'           => 'application/vnd.ms-excel',
        'xls'           => 'application/vnd.ms-excel',
        'xlt'           => 'application/vnd.ms-excel',
        'xlw'           => 'application/vnd.ms-excel',
        'xm'            => 'audio/x-xm',
        'xmi'           => 'text/x-xmi',
        'xml'           => 'text/xml',
        'xpm'           => 'image/x-xpixmap',
        'xsl'           => 'text/x-xslt',
        'xslfo'         => 'text/x-xslfo',
        'xslt'          => 'text/x-xslt',
        'xul'           => 'application/vnd.mozilla.xul+xml',
        'xwd'           => 'image/x-xwindowdump',
        'xyz'           => 'chemical/x-xyz',
        'zabw'          => 'application/x-abiword',
        'zip'           => 'application/zip',
        'zoo'           => 'application/x-zoo',
        '123'           => 'application/vnd.lotus-1-2-3',
        '669'           => 'audio/x-mod'
        );
    }
}

?>
