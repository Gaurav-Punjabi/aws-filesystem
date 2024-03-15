<?php

namespace App\Http\Controllers;

use App\Models\Metadata;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function showPath(Request $request) {
        $path = null;
        if($request->has("path")) {
            $path = $request->get("path");
        }

        $parent = null;
        if($path) {
            $directory = basename($path);
            $parent = Metadata::where('name', $directory)->firstOrFail()->id;
        }

        $parentQuery = $parent ? "parent_id = $parent" : "parent_id is null";

        $items = Metadata::whereRaw($parentQuery)->get();

        $prettyPath = $path ? $path : "";

        return view("index")->with([
            'files' => $items,
            'path' => $prettyPath
        ]);
    }

    public function remove(Request $request, $id) {
        $metadata = Metadata::findOrFail($id);



        $storagePath = $this->getStoragePath($id);
        $relativePath = "public/root$storagePath";
//        dd($relativePath);
        if(Storage::disk('s3')->exists($relativePath)) {
            if($metadata->is_file) {
                Storage::disk('s3')->delete($relativePath);
            } else {
                Storage::disk('s3')->deleteDirectory($relativePath);
            }
        }

        $metadata->delete();

        return redirect()->back();
    }

    public function search(Request $request) {
        $request->validate([
            'term' => 'required|string'
        ]);
        $term = $request->get('term');

        $items = Metadata::where('name', 'like', "%$term%")->get();
        return view("index")->with([
            'files' => $items,
            'path' => '',
            'term' => $term
        ]);
    }

    public function createFolder(Request $request) {
        $request->validate([
            'name' => 'required|string'
        ]);
        $name = $request->get('name');
        $path = null;
        if($request->has("path")) {
            $path = $request->get("path");
        }

        $parent = null;
        if($path) {
            $directory = basename($path);
            $parent = Metadata::where('name', $directory)->firstOrFail()->id;
        }

        Metadata::create([
            'name' => $name,
            'parent_id' => $parent,
            'uploaded_by' => $request->ip(),
            'is_file' => 0
        ]);

        return redirect()->route('show-path', ['name' => $path]);
    }

    public function uploadFile(Request $request) {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $path = $request->has('path') ? $request->get('path') : null;
        $name = $file->getClientOriginalName();

        if($this->checkIfFileExists($name)) {
            return response()->json([
                'message' => "File already exists"
            ], 400);
        }
        $storagePath = $path ? "public/root/$path" : "public/root";
        $parentId = $this->getParentId($path);
        $file->storeAs($storagePath, $name, 's3');


        Metadata::create([
            'name' => $name,
            'is_file' => 1,
            'parent_id' => $parentId,
            'uploaded_by' => $request->ip()
        ]);

        return response()->json([
            'path' => $path,
            'name' => 'name'
        ]);
    }

    public function openFile($id) {
        $storagePath = $this->getStoragePath($id);
        $publicPath = "public/root$storagePath";

        $fileContents = Storage::disk('s3')->get($publicPath);

        // Determine the MIME type based on file extension
        $mimeType = $this->getMimeType($publicPath);

        // Return the file with appropriate headers
        return response($fileContents)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $publicPath . '"');

    }

    public function getStoragePath($id) {
        $metadata = Metadata::findOrFail($id);
        $storagePath = "";
        while($metadata) {
            $storagePath = "/$metadata->name" . $storagePath;
            $metadata = $metadata->parent;
        }

        return $storagePath;
    }

    private function checkIfFileExists($name) {
        $count = Metadata::where('name', $name)->count();

        return $count > 0;
    }

    private function getParentId($path) {
        if(!$path)
            return null;
        $directory = basename($path);
        $obj = Metadata::where('name', $directory)->get()->first();

        if($obj) {
            return $obj->id;
        }
    }



    private function getMimeType($filePath)
    {
        // Map file extensions to MIME types
        $mimeTypes = [
            'ai' => 'application/postscript',
            'aif' => 'audio/x-aiff',
            'aifc' => 'audio/x-aiff',
            'aiff' => 'audio/x-aiff',
            'asc' => 'text/plain',
            'atom' => 'application/atom+xml',
            'au' => 'audio/basic',
            'avi' => 'video/x-msvideo',
            'bcpio' => 'application/x-bcpio',
            'bin' => 'application/octet-stream',
            'bmp' => 'image/bmp',
            'cdf' => 'application/x-netcdf',
            'cgm' => 'image/cgm',
            'class' => 'application/octet-stream',
            'cpio' => 'application/x-cpio',
            'cpt' => 'application/mac-compactpro',
            'csh' => 'application/x-csh',
            'css' => 'text/css',
            'dcr' => 'application/x-director',
            'dif' => 'video/x-dv',
            'dir' => 'application/x-director',
            'djv' => 'image/vnd.djvu',
            'djvu' => 'image/vnd.djvu',
            'dll' => 'application/octet-stream',
            'dmg' => 'application/octet-stream',
            'dms' => 'application/octet-stream',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
            'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
            'dtd' => 'application/xml-dtd',
            'dv' => 'video/x-dv',
            'dvi' => 'application/x-dvi',
            'dxr' => 'application/x-director',
            'eps' => 'application/postscript',
            'etx' => 'text/x-setext',
            'exe' => 'application/octet-stream',
            'ez' => 'application/andrew-inset',
            'gif' => 'image/gif',
            'gram' => 'application/srgs',
            'grxml' => 'application/srgs+xml',
            'gtar' => 'application/x-gtar',
            'hdf' => 'application/x-hdf',
            'hqx' => 'application/mac-binhex40',
            'htm' => 'text/html',
            'html' => 'text/html',
            'ice' => 'x-conference/x-cooltalk',
            'ico' => 'image/x-icon',
            'ics' => 'text/calendar',
            'ief' => 'image/ief',
            'ifb' => 'text/calendar',
            'iges' => 'model/iges',
            'igs' => 'model/iges',
            'jnlp' => 'application/x-java-jnlp-file',
            'jp2' => 'image/jp2',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'js' => 'application/x-javascript',
            'kar' => 'audio/midi',
            'latex' => 'application/x-latex',
            'lha' => 'application/octet-stream',
            'lzh' => 'application/octet-stream',
            'm3u' => 'audio/x-mpegurl',
            'm4a' => 'audio/mp4a-latm',
            'm4b' => 'audio/mp4a-latm',
            'm4p' => 'audio/mp4a-latm',
            'm4u' => 'video/vnd.mpegurl',
            'm4v' => 'video/x-m4v',
            'mac' => 'image/x-macpaint',
            'man' => 'application/x-troff-man',
            'mathml' => 'application/mathml+xml',
            'me' => 'application/x-troff-me',
            'mesh' => 'model/mesh',
            'mid' => 'audio/midi',
            'midi' => 'audio/midi',
            'mif' => 'application/vnd.mif',
            'mov' => 'video/quicktime',
            'movie' => 'video/x-sgi-movie',
            'mp2' => 'audio/mpeg',
            'mp3' => 'audio/mpeg',
            'mp4' => 'video/mp4',
            'mpe' => 'video/mpeg',
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpga' => 'audio/mpeg',
            'ms' => 'application/x-troff-ms',
            'msh' => 'model/mesh',
            'mxu' => 'video/vnd.mpegurl',
            'nc' => 'application/x-netcdf',
            'oda' => 'application/oda',
            'ogg' => 'application/ogg',
            'pbm' => 'image/x-portable-bitmap',
            'pct' => 'image/pict',
            'pdb' => 'chemical/x-pdb',
            'pdf' => 'application/pdf',
            'pgm' => 'image/x-portable-graymap',
            'pgn' => 'application/x-chess-pgn',
            'pic' => 'image/pict',
            'pict' => 'image/pict',
            'png' => 'image/png',
            'pnm' => 'image/x-portable-anymap',
            'pnt' => 'image/x-macpaint',
            'pntg' => 'image/x-macpaint',
            'ppm' => 'image/x-portable-pixmap',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
            'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
            'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
            'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
            'ps' => 'application/postscript',
            'qt' => 'video/quicktime',
            'ra' => 'audio/x-pn-realaudio',
            'ram' => 'audio/x-pn-realaudio',
            'ras' => 'image/x-cmu-raster',
            'rdf' => 'application/rdf+xml',
            'rgb' => 'image/x-rgb',
            'rm' => 'application/vnd.rn-realmedia',
            'roff' => 'application/x-troff',
            'rtf' => 'text/rtf',
            'rtx' => 'text/richtext',
            'sgm' => 'text/sgml',
            'sgml' => 'text/sgml',
            'sh' => 'application/x-sh',
            'shar' => 'application/x-shar',
            'silo' => 'model/mesh',
            'sit' => 'application/x-stuffit',
            'skd' => 'application/x-koan',
            'skm' => 'application/x-koan',
            'skp' => 'application/x-koan',
            'skt' => 'application/x-koan',
            'smi' => 'application/smil',
            'smil' => 'application/smil',
            'snd' => 'audio/basic',
            'so' => 'application/octet-stream',
            'spl' => 'application/x-futuresplash',
            'src' => 'application/x-wais-source',
            'sv4cpio' => 'application/x-sv4cpio',
            'sv4crc' => 'application/x-sv4crc',
            'svg' => 'image/svg+xml',
            'swf' => 'application/x-shockwave-flash',
            't' => 'application/x-troff',
            'tar' => 'application/x-tar',
            'tcl' => 'application/x-tcl',
            'tex' => 'application/x-tex',
            'texi' => 'application/x-texinfo',
            'texinfo' => 'application/x-texinfo',
            'tgz' => 'application/x-gzip',
            'th' => 'application/x-th',
            'tif' => 'image/tiff',
            'tiff' => 'image/tiff',
            'tr' => 'application/x-troff',
            'tsv' => 'text/tab-separated-values',
            'txt' => 'text/plain',
            'ustar' => 'application/x-ustar',
            'vcd' => 'application/x-cdlink',
            'vrml' => 'model/vrml',
            'vxml' => 'application/voicexml+xml',
            'wav' => 'audio/x-wav',
            'wbmp' => 'image/vnd.wap.wbmp',
            'wbmxl' => 'application/vnd.wap.wbxml',
            'wml' => 'text/vnd.wap.wml',
            'wmlc' => 'application/vnd.wap.wmlc',
            'wmls' => 'text/vnd.wap.wmlscript',
            'wmlsc' => 'application/vnd.wap.wmlscriptc',
            'wmv' => 'video/x-ms-wmv',
            'wrl' => 'model/vrml',
            'xbm' => 'image/x-xbitmap',
            'xht' => 'application/xhtml+xml',
            'xhtml' => 'application/xhtml+xml',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
            'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
            'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
            'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'xml' => 'application/xml',
            'xpm' => 'image/x-xpixmap',
            'xsl' => 'application/xml',
            'xslt' => 'application/xslt+xml',
            'xul' => 'application/vnd.mozilla.xul+xml',
            'xwd' => 'image/x-xwindowdump',
            'xyz' => 'chemical/x-xyz',
            'zip' => 'application/zip',
        ];

        // Get the file extension
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Look up the MIME type for the extension
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
