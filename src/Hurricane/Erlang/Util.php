<?php

/**
 * Implementation of the Erlang binary protocol.
 *
 * Provides facilities to work with Standard I/O streams, sockets, and
 * Erlang binary messages.
 */
namespace Hurricane\Erlang;

class Util
{
    const MACHINE_ENDIANNESS_LITTLE_ENDIAN = 'LITTLE_ENDIAN';
    const MACHINE_ENDIANNESS_BIG_ENDIAN = 'BIG_ENDIAN';
    private static $machineEndiness;

    /**
     * set MACHINE_ENDIANNESS only once, forever, when requested
     *
     * @static
     * @return string MACHINE_ENDIANNESS
     */
    public static function getMachineEndianness()
    {
        if (self::$machineEndiness === null) {
            if (reset((unpack('L', "\x00\x00\x00\x01"))) == 1) {
                self::$machineEndiness = self::MACHINE_ENDIANNESS_BIG_ENDIAN;
            } else {
                self::$machineEndiness = self::MACHINE_ENDIANNESS_LITTLE_ENDIAN;
            }
        }
        return self::$machineEndiness;
    }

    /**
     * Turn an Erlang-style property list into a map.
     *
     * @static
     * @param array $input
     * @return array
     */
    public static function proplistToArray(array $input)
    {
        $result = array();
        foreach ($input as $element) {
            if (count($element->data) < 2) {
                throw new Exception(
                    'Proplist elements should have at least 2 elements'
                );
            }
            $result[$element->data[0]] = $element->data[1];
        }
        return $result;
    }

    /**
     * Decode and return an Erlang atom cache ref.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\AtomCacheRef
     */
    public static function decode_atom_cache_ref(StreamInterface $stream)
    {
        return new DataType\AtomCacheRef(ord($stream->read(1)));
    }

    /**
     * Decode and return a small integer (byte).
     *
     * @static
     * @param StreamInterface $stream
     * @return integer
     */
    public static function decode_small_integer_ext(StreamInterface $stream)
    {
        return ord($stream->read(1));
    }

    /**
     * Decode and return an integer.
     *
     * @static
     * @param StreamInterface $stream
     * @return integer
     */
    public static function decode_integer_ext(StreamInterface $stream)
    {
        $val = $stream->read(4);
        if (self::getMachineEndianness() == self::MACHINE_ENDIANNESS_LITTLE_ENDIAN) {
            $val = strrev($val);
        }
        return reset((unpack('l', $val)));
    }

    /**
     * Decode and return a float (represented by Erlang as a string).
     *
     * @static
     * @param StreamInterface $stream
     * @return integer double
     */
    public static function decode_float_ext(StreamInterface $stream)
    {
        return (double) $stream->read(31);
    }

    /**
     * Decode and return an Erlang atom.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Atom
     */
    public static function decode_atom_ext(StreamInterface $stream)
    {
        $atom_len = reset((unpack('n', $stream->read(2))));
        return new DataType\Atom($stream->read($atom_len));
    }

    /**
     * Decode and return an Erlang reference.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Reference
     */
    public static function decode_reference_ext(StreamInterface $stream)
    {
        $atom = self::decode($stream, false);
        $identifier = reset((unpack('N', $stream->read(4))));
        $creation = ord($stream->read(1));
        return new DataType\Reference($atom, $identifier, $creation);
    }

    /**
     * Decode and return an Erlang port.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Port
     */
    public static function decode_port_ext(StreamInterface $stream)
    {
        $atom = self::decode($stream, false);
        $identifier = reset((unpack('N', $stream->read(4))));
        $creation = ord($stream->read(1));
        return new DataType\Port($atom, $identifier, $creation);
    }

    /**
     * Decode and return an Erlang pid.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Pid
     */
    public static function decode_pid_ext(StreamInterface $stream)
    {
        $atom = self::decode($stream, false);
        $identifier = reset((unpack('N', $stream->read(4))));
        $serial = reset((unpack('N', $stream->read(4))));
        $creation = ord($stream->read(1));
        return new DataType\Pid($atom, $identifier, $serial, $creation);
    }

    /**
     * Decode and return a small Erlang tuple (fewer than 256 elements).
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Tuple
     */
    public static function decode_small_tuple_ext(StreamInterface $stream)
    {
        $tuple_len = ord($stream->read(1));
        $elements = array();
        for ($i = 0; $i < $tuple_len; $i++) {
            $value = self::decode($stream, false);
            $elements[] = $value;
        }
        return new DataType\Tuple($elements);
    }

    /**
     * Decode and return a large Erlang tuple (more than 256 elements).
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Tuple
     */
    public static function decode_large_tuple_ext(StreamInterface $stream)
    {
        $tuple_len = reset((unpack('N', $stream->read(4))));
        $elements = array();
        for ($i = 0; $i < $tuple_len; $i++) {
            $value = self::decode($stream, false);
            $elements[] = $value;
        }
        return new DataType\Tuple($elements);
    }

    /**
     * Decode and return a nil/null/None.
     *
     * @static
     * @return null
     */
    public static function decode_nil_ext()
    {
        return null;
    }

    /**
     * Decode and return a string.
     *
     * @static
     * @param StreamInterface $stream
     * @return string
     */
    public static function decode_string_ext(StreamInterface $stream)
    {
        $str_len = reset((unpack('n', $stream->read(2))));
        return $stream->read($str_len);
    }

    /**
     * Decode and return a list.
     *
     * Depending on the list contents, a string may be returned. This will
     * be the case if the list contains only byte values, which means that
     * the list is actually intending to be a string, but being capped by
     * Erlang's 65K char limit for strings (before they overflow into a list).
     *
     * @static
     * @param StreamInterface $stream
     * @return array
     */
    public static function decode_list_ext(StreamInterface $stream)
    {
        $list_len = reset((unpack('N', $stream->read(4))));
        $elements = array();
        $is_str = true;
        
        // @todo $value might not be defined here...
        for ($i = 0; $i < $list_len; $i++) {
            $value = self::decode($stream, false);
            $is_str = $is_str && is_numeric($value) && $value < 256;
            $elements[] = $value;
        }
        $tail = self::decode($stream, false);
        if ($tail !== null) {
            $is_str = $is_str && is_numeric($value) && $value < 256;
            $elements[] = $tail;
        }

        if ($is_str) {
            $outstr = '';
            foreach ($elements as $element) {
                $outstr .= chr($element);
            }
            return $outstr;
        } else {
            return $elements;
        }
    }

    /**
     * Decode and return an Erlang binary.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Binary
     */
    public static function decode_binary_ext(StreamInterface $stream)
    {
        $bin_len = reset((unpack('N', $stream->read(4))));
        return new DataType\Binary($stream->read($bin_len));
    }

    /**
     * Decode and return "small" big number. Uses doubles to store results,
     * as PHP does not have a big integer type.
     *
     * @static
     * @param StreamInterface $stream
     * @return integer double
     */
    public static function decode_small_big_ext(StreamInterface $stream)
    {
        $num_bytes = ord($stream->read(1));
        $sign = ord($stream->read(1));
        $num = 0.0;
        for ($i = 0; $i < $num_bytes; $i++) {
            $num += (double) ord($stream->read(1)) * (double) pow(256, $i);
        }
        if ($sign == 1) {
            $num *= -1.0;
        }
        return $num;
    }

    /**
     * Decode and return "large" big number. Uses doubles to store results,
     * as PHP does not have a big integer type.
     *
     * @static
     * @param StreamInterface $stream
     * @return integer
     */
    public static function decode_large_big_ext(StreamInterface $stream)
    {
        $num_bytes = reset((unpack('N', $stream->read(4))));
        $sign = ord($stream->read(1));
        $num = 0.0;
        for ($i = 0; $i < $num_bytes; $i++) {
            $num += (double) ord($stream->read(1)) * (double) pow(256, $i);
        }
        if ($sign == 1) {
            $num *= -1.0;
        }
        return $num;
    }

    /**
     * Decode and return an Erlang "new reference".
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\NewReference
     */
    public static function decode_new_reference_ext(StreamInterface $stream)
    {
        $length = reset((unpack('n', $stream->read(2))));
        $atom = self::decode($stream, false);
        $creation = ord($stream->read(1));
        $ids = array();
        for ($i = 0; $i < $length; $i++) {
            $id = reset((unpack('N', $stream->read(4))));
            array_unshift($ids, $id);
        }
        return new DataType\NewReference($atom, $creation, $ids);
    }

    /**
     * Decode and return a small Erlang atom.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Atom
     */
    public static function decode_small_atom_ext(StreamInterface $stream)
    {
        $atom_len = ord($stream->read(1));
        $atom_name = $stream->read($atom_len);
        return new DataType\Atom($atom_name);
    }

    /**
     * Decode and return an Erlang "new function".
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\NewFunction
     */
    public static function decode_new_fun_ext(StreamInterface $stream)
    {
        unpack('N', $stream->read(4));
        $arity = ord($stream->read(1));
        $uniq = $stream->read(16);
        $index = reset((unpack('N', $stream->read(4))));
        $num_free = reset((unpack('N', $stream->read(4))));
        $module = self::decode($stream, false);
        $old_index = self::decode($stream, false);
        $old_uniq = self::decode($stream, false);
        $pid = self::decode($stream, false);
        $free_vars = array();
        for ($i = 0; $i < $num_free; $i++) {
            $free_var = self::decode($stream, false);
            $free_vars[] = $free_var;
        }
        if (!count($free_vars)) {
            $free_vars = null;
        }

        return new DataType\NewFunction(
            $arity, $uniq, $index, $module,
            $old_index, $old_uniq, $pid, $free_vars);
    }

    /**
     * Decode and return an Erlang export.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\Export
     */
    public static function decode_export_ext(StreamInterface $stream)
    {
        $module = self::decode($stream, false);
        $function = self::decode($stream, false);
        $arity = self::decode($stream, false);
        return new DataType\Export($module, $function, $arity);
    }

    /**
     * Decode and return an Erlang function.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\ErlFunction
     */
    public static function decode_fun_ext(StreamInterface $stream)
    {
        $num_free = reset((unpack('N', $stream->read(4))));
        $pid = self::decode($stream, false);
        $module = self::decode($stream, false);
        $index = self::decode($stream, false);
        $uniq = self::decode($stream, false);
        $free_vars = array();
        for ($i = 0; $i < $num_free; $i++) {
            $free_var = self::decode($stream, false);
            $free_vars[] = $free_var;
        }
        if (!count($free_vars)) {
            $free_vars = null;
        }

        return new DataType\ErlFunction($pid, $module, $index, $uniq, $free_vars);
    }

    /**
     * Decode and return an Erlang bit binary.
     *
     * @static
     * @param StreamInterface $stream
     * @return DataType\BitBinary
     */
    public static function decode_bit_binary_ext(StreamInterface $stream)
    {
        $length = reset((unpack('N', $stream->read(4))));
        return new DataType\BitBinary(ord($stream->read(1)), $stream->read($length));
    }

    /**
     * Decode and return an IEEE 8-byte floating-point number.
     *
     * @static
     * @param StreamInterface $stream
     * @return float
     */
    public static function decode_new_float_ext(StreamInterface $stream)
    {
        $data = $stream->read(8);
        if (self::getMachineEndianness() == self::MACHINE_ENDIANNESS_LITTLE_ENDIAN) {
            $data = strrev($data);
        }
        return reset((unpack('d', $data)));
    }

    /**
     * Decode a single value from the given stream and return it.
     *
     * If check_dist_tag, check to see that the first byte is 131 (this is
     * how Erlang flags the beginning of every data type). This check does
     * not need to be performed when recursively decoding nested data types,
     * hence the optional argument.
     *
     * @static
     * @param StreamInterface $stream
     * @param boolean $check_dist_tag
     * @return mixed
     */
    public static function decode(StreamInterface $stream, $check_dist_tag=true)
    {
        $first_byte = ord($stream->read(1));
        if ($check_dist_tag) {
            if ($first_byte != 131) {
                throw new Exception('this is not an Erlang EXT datatype');
            } else {
                $ext_code = ord($stream->read(1));
            }
        } else {
            $ext_code = $first_byte;
        }

        switch ($ext_code) {
            case 70: return self::decode_new_float_ext($stream);
            case 77: return self::decode_bit_binary_ext($stream);
            case 82: return self::decode_atom_cache_ref($stream);
            case 97: return self::decode_small_integer_ext($stream);
            case 98: return self::decode_integer_ext($stream);
            case 99: return self::decode_float_ext($stream);
            case 100: return self::decode_atom_ext($stream);
            case 101: return self::decode_reference_ext($stream);
            case 102: return self::decode_port_ext($stream);
            case 103: return self::decode_pid_ext($stream);
            case 104: return self::decode_small_tuple_ext($stream);
            case 105: return self::decode_large_tuple_ext($stream);
            case 106: return self::decode_nil_ext();
            case 107: return self::decode_string_ext($stream);
            case 108: return self::decode_list_ext($stream);
            case 109: return self::decode_binary_ext($stream);
            case 110: return self::decode_small_big_ext($stream);
            case 111: return self::decode_large_big_ext($stream);
            case 112: return self::decode_new_fun_ext($stream);
            case 113: return self::decode_export_ext($stream);
            case 114: return self::decode_new_reference_ext($stream);
            case 115: return self::decode_small_atom_ext($stream);
            case 117: return self::decode_fun_ext($stream);
            default:
                throw new Exception(
                    'Unable to decode Erlang EXT data type: ' . $ext_code
                );
        }
    }

    /**
     * Encode a floating-point number into the stream.
     *
     * @static
     * @param float $data
     * @param StreamInterface $stream
     */
    public static function encode_float($data, StreamInterface $stream)
    {
        $stream->write(chr(70));
        $val = pack('d', $data);
        if (self::getMachineEndianness() == self::MACHINE_ENDIANNESS_LITTLE_ENDIAN) {
            $val = strrev($val);
        }
        $stream->write($val);
    }

    /**
     * Encode an Erlang bit binary into the stream.
     *
     * @static
     * @param DataType\BitBinary $data
     * @param StreamInterface $stream
     */
    public static function encode_bit_binary(DataType\BitBinary $data, StreamInterface $stream)
    {
        $stream->write(chr(77));
        $stream->write(pack('N', strlen($data->data)));
        $stream->write(chr($data->bits));
        $stream->write($data->data);
    }

    /**
     * Encode an Erlang atom cache ref into the stream.
     *
     * @static
     * @param DataType\AtomCacheRef $data
     * @param StreamInterface $stream
     */
    public static function encode_atom_cache_ref(DataType\AtomCacheRef $data, StreamInterface $stream)
    {
        $stream->write(chr(82));
        $stream->write(chr($data->getValue()));
    }

    /**
     * Encode a small integer (byte) into the stream.
     *
     * @static
     * @param integer $data
     * @param StreamInterface $stream
     */
    public static function encode_small_integer($data, StreamInterface $stream)
    {
        $stream->write(chr(97));
        $stream->write(chr($data));
    }

    /**
     * Encode an integer into the stream.
     *
     * @static
     * @param integer $data
     * @param StreamInterface $stream
     */
    public static function encode_integer($data, StreamInterface $stream)
    {
        $stream->write(chr(98));
        $stream->write(pack('N', $data));
    }

    /**
     * Encode any-size number into the stream.
     *
     * @static
     * @param integer $data
     * @param StreamInterface $stream
     */
    public static function encode_number($data, StreamInterface $stream)
    {
        if ($data >= 0 && $data <= 0xff) {
            self::encode_small_integer($data, $stream);
        } elseif ($data >= -0x7fffffff - 1 && $data <= 0x7fffffff) {
            self::encode_integer($data, $stream);
        }
    }

    /**
     * Encode an Erlang atom into the stream.
     *
     * @static
     * @param DataType\Atom $data
     * @param StreamInterface $stream
     */
    public static function encode_atom(DataType\Atom $data, StreamInterface $stream)
    {
        $name_len = strlen($data->getName());
        if ($name_len <= 0xf) {
            $stream->write(chr(115));
            $stream->write(chr($name_len));
        } else {
            $stream->write(chr(100));
            $stream->write(pack('n', $name_len));
        }
        $stream->write($data->getName());
    }

    /**
     * Encode an Erlang reference into the stream.
     *
     * @static
     * @param DataType\Reference $data
     * @param StreamInterface $stream
     */
    public static function encode_reference(DataType\Reference $data, StreamInterface $stream)
    {
        $stream->write(chr(101));
        self::encode($data->atom, $stream, false);
        $stream->write(pack('N', $data->identifier));
        $stream->write(chr($data->creation));
    }

    /**
     * Encode an Erlang port into the stream.
     *
     * @static
     * @param DataType\Port $data
     * @param StreamInterface $stream
     */
    public static function encode_port(DataType\Port $data, StreamInterface $stream)
    {
        $stream->write(chr(102));
        self::encode($data->atom, $stream, false);
        $stream->write(pack('N', $data->identifier));
        $stream->write(chr($data->creation));
    }

    /**
     * Encode an Erlang pid into the stream.
     *
     * @static
     * @param DataType\Pid $data
     * @param StreamInterface $stream
     */
    public static function encode_pid(DataType\Pid $data, StreamInterface $stream)
    {
        $stream->write(chr(103));
        self::encode($data->atom, $stream, false);
        $stream->write(pack('N', $data->identifier));
        $stream->write(pack('N', $data->serial));
        $stream->write(chr($data->creation));
    }

    /**
     * Encode a tuple into the stream.
     *
     * @static
     * @param DataType\Tuple $data
     * @param StreamInterface $stream
     */
    public static function encode_tuple(DataType\Tuple $data, StreamInterface $stream)
    {
        $data_len = count($data->data);
        if (count($data->data) < 256) {
            $stream->write(chr(104));
            $stream->write(chr($data_len));
        } else {
            $stream->write(chr(105));
            $stream->write(pack('N', $data_len));
        }
        foreach ($data->data as $datum) {
            self::encode($datum, $stream, false);
        }
    }

    /**
     * Encode a NoneType into the stream (as Erlang nil).
     *
     * @static
     * @param StreamInterface $stream
     */
    public static function encode_null(StreamInterface $stream)
    {
        $stream->write(chr(106));
    }

    /**
     * Encode an Erlang binary into the stream.
     *
     * @static
     * @param DataType\Binary $data
     * @param StreamInterface $stream
     */
    public static function encode_binary(DataType\Binary $data, StreamInterface $stream)
    {
        $stream->write(chr(109));
        $stream->write(pack('N', strlen($data->getData())));
        $stream->write($data->getData());
    }

    /**
     * Encode a string into the stream.
     *
     * @static
     * @param string $data
     * @param StreamInterface $stream
     */
    public static function encode_str($data, StreamInterface $stream)
    {
        $data_len = strlen($data);
        if ($data_len > 0xffff) {
            $stream->write(chr(108));
            $stream->write(pack('N', $data_len));
            for ($i = 0; $i < $data_len; $i++) {
                self::encode(ord($data[$i]), $stream, false);
            }
            $stream->write(chr(106));
        } else {
            $stream->write(chr(107));
            $stream->write(pack('n', $data_len));
            $stream->write($data);
        }
    }

    /**
     * Encode a list into the stream.
     *
     * @static
     * @param array $data
     * @param StreamInterface $stream
     */
    public static function encode_list(array $data, StreamInterface $stream)
    {
        $stream->write(chr(108));
        $stream->write(pack('N', count($data)));
        foreach ($data as $value) {
            self::encode($value, $stream, false);
        }
        $stream->write(chr(106));
    }

    /**
     * Encode an associative array into the stream (as a property list).
     *
     * @static
     * @param array $data
     * @param StreamInterface $stream
     */
    public static function encode_dict(array $data, StreamInterface $stream)
    {
        $stream->write(chr(108));
        $stream->write(pack('N', count($data)));
        foreach ($data as $key => $value) {
            self::encode(new DataType\Tuple(array($key, $value)), $stream, false);
        }
        $stream->write(chr(106));
    }

    /**
     * Encode an array into the stream (list or associative).
     *
     * The way that an array is deemed to be a list is its keys are compared
     * to the range of numbers represented by [0..C] where C is the size of
     * the array.
     *
     * @static
     * @param array $data
     * @param StreamInterface $stream
     */
    public static function encode_array($data, StreamInterface $stream)
    {
        if (array_keys($data) === range(0, count($data) - 1)) {
            self::encode_list($data, $stream);
        } else {
            self::encode_dict($data, $stream);
        }
    }

    /**
     * Encode an Erlang new reference into the stream.
     *
     * @static
     * @param DataType\NewReference $data
     * @param StreamInterface $stream
     */
    public static function encode_new_reference(DataType\NewReference $data, StreamInterface $stream)
    {
        $stream->write(chr(114));
        $ids_len = count($data->ids);
        $stream->write(pack('n', $ids_len));
        self::encode($data->atom, $stream, false);
        $stream->write(chr($data->creation));
        foreach ($data->ids as $id) {
            $stream->write(pack('N', $id));
        }
    }

    /**
     * Encode an Erlang function into the stream.
     *
     * @static
     * @param DataType\ErlFunction $data
     * @param StreamInterface $stream
     */
    public static function encode_function(DataType\ErlFunction $data, StreamInterface $stream)
    {
        $stream->write(chr(117));
        if ($data->free_vars == null) {
            $free_vars_len = 0;
        } else {
            $free_vars_len = count($data->free_vars);
        }
        $stream->write(pack('N', $free_vars_len));
        self::encode($data->pid, $stream, false);
        self::encode($data->module, $stream, false);
        self::encode($data->index, $stream, false);
        self::encode($data->uniq, $stream, false);
        if ($free_vars_len > 0) {
            foreach ($data->free_vars as $free_var) {
                $stream->write(pack('N', $free_var));
            }
        }
    }

    /**
     * Encode an Erlang "new function" into the stream.
     *
     * @static
     * @param DataType\NewFunction $data
     * @param StreamInterface $stream
     */
    public static function encode_new_function(DataType\NewFunction $data, StreamInterface $stream)
    {
        $stream->write(chr(112));
        if ($data->free_vars == null) {
            $free_vars_len = 0;
        } else {
            $free_vars_len = count($data->free_vars);
        }

        $bytes = new StreamEmulator();
        $bytes->write(chr($data->arity));
        $bytes->write($data->uniq);
        $bytes->write(pack('N', $data->index));
        $bytes->write(pack('N', $free_vars_len));
        self::encode($data->module, $bytes, false);
        self::encode($data->old_index, $bytes, false);
        self::encode($data->old_uniq, $bytes, false);
        self::encode($data->pid, $bytes, false);
        if ($free_vars_len > 0) {
            foreach ($data->free_vars as $free_var) {
                $bytes->write(pack('N', $free_var));
            }
        }
        $stream->write(pack('N', strlen($bytes->data) + 4));
        $stream->write($bytes->data);
    }

    /**
     * Encode an Erlang export into the stream.
     *
     * @static
     * @param DataType\Export $data
     * @param StreamInterface $stream
     */
    public static function encode_export(DataType\Export $data, StreamInterface $stream)
    {
        $stream->write(chr(113));
        self::encode($data->module, $stream, false);
        self::encode($data->function, $stream, false);
        self::encode($data->arity, $stream, false);
    }

    /**
     * Encode the given data into the given stream.
     *
     * If send_magic_byte, the value 131 is sent before anything (this is
     * how Erlang denotes that there is a new piece of data coming across).
     * However, for nested data, this only needs to be sent once, hence
     * the optional argument.
     *
     * @static
     * @param mixed $data
     * @param StreamInterface $stream
     * @param bool $send_magic_byte
     */
    public static function encode($data, StreamInterface $stream, $send_magic_byte=true)
    {
        if ($send_magic_byte) {
            $stream->write(chr(131));
        }

        if     (is_float($data))                        { self::encode_float($data, $stream); }
        elseif ($data instanceof DataType\AtomCacheRef) { self::encode_atom_cache_ref($data, $stream); }
        elseif (is_numeric($data))                      { self::encode_number($data, $stream); }
        elseif ($data instanceof DataType\Atom)         { self::encode_atom($data, $stream); }
        elseif ($data instanceof DataType\Reference)    { self::encode_reference($data, $stream); }
        elseif ($data instanceof DataType\Port)         { self::encode_port($data, $stream); }
        elseif ($data instanceof DataType\Pid)          { self::encode_pid($data, $stream); }
        elseif ($data instanceof DataType\Tuple)        { self::encode_tuple($data, $stream); }
        elseif ($data == null)                          { self::encode_null($stream); }
        elseif (is_string($data))                       { self::encode_str($data, $stream); }
        elseif (is_array($data))                        { self::encode_array($data, $stream); }
        elseif ($data instanceof DataType\Binary)       { self::encode_binary($data, $stream); }
        elseif ($data instanceof DataType\NewReference) { self::encode_new_reference($data, $stream); }
        elseif ($data instanceof DataType\ErlFunction)  { self::encode_function($data, $stream); }
        elseif ($data instanceof DataType\NewFunction)  { self::encode_new_function($data, $stream); }
        elseif ($data instanceof DataType\BitBinary)    { self::encode_bit_binary($data, $stream); }
        elseif ($data instanceof DataType\Export)       { self::encode_export($data, $stream); }
        /** @var $data Serializable */
        elseif ($data instanceof Serializable)          { self::encode($data->toErlang(), $stream, false); }
        else {
            throw new Exception(get_class($data) . ' is not Erlang serializable');
        }
    }

    /**
     * Transform an array of bytes into a binary string.
     *
     * @static
     * @param array $input
     * @return string
     */
    public static function to_binary($input)
    {
        $output = '';
        foreach ($input as $val) {
            $output .= chr($val);
        }
        return $output;
    }

    /**
     * Transform a binary string into an array of bytes.
     *
     * @static
     * @param string $input
     * @return array
     */
    public static function from_binary($input)
    {
        $output = array();
        for ($i = 0; $i < strlen($input); $i++) {
            $output[] = ord($input[$i]);
        }
        return $output;
    }
}
