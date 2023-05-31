rule M_Hunting_Linux_Funchook
 {
     strings:
         $f = "funchook_"
         $s1 = "Enter funchook_create()"
         $s2 = "Leave funchook_create() => %p"
         $s3 = "Enter funchook_prepare(%p, %p, %p)"
         $s4 = "Leave funchook_prepare(..., [%p->%p],...) => %d"
         $s5 = "Enter funchook_install(%p, 0x%x)"
         $s6 = "Leave funchook_install() => %d"
         $s7 = "Enter funchook_uninstall(%p, 0x%x)"
         $s8 = "Leave funchook_uninstall() => %d"
         $s9 = "Enter funchook_destroy(%p)"
         $s10 = "Leave funchook_destroy() => %d"
         $s11 = "Could not modify already-installed funchook handle."
         $s12 = "  change %s address from %p to %p"
         $s13 = "  link_map addr=%p, name=%s"
         $s14 = "  ELF type is neither ET_EXEC nor ET_DYN."
         $s15 = "  not a valid ELF module %s."
         $s16 = "Failed to protect memory %p (size=%"
         $s17 = "  protect memory %p (size=%"
         $s18 = "Failed to unprotect memory %p (size=%"
         $s19 = "  unprotect memory %p (size=%"
         $s20 = "Failed to unprotect page %p (size=%"
         $s21 = "  unprotect page %p (size=%"
         $s22 = "Failed to protect page %p (size=%"
         $s23 = "  protect page %p (size=%"
         $s24 = "Failed to deallocate page %p (size=%"
         $s25 = " deallocate page %p (size=%"
         $s26 = "  allocate page %p (size=%"
         $s27 = "  try to allocate %p but %p (size=%"
         $s28 = "  allocate page %p (size=%"
         $s29 = "Could not find a free region near %p"
         $s30 = "  -- Use address %p or %p for function %p"
     condition:
         filesize < 15MB and uint32(0) == 0x464c457f and (#f > 5 or 4 of ($s*))
 }

rule M_Hunting_Linux_SALTWATER_1
 {
     strings:
         $s1 = { 71 75 69 74 0D 0A 00 00 00 33 8C 25 3D 9C 17 70 08 F9 0C 1A 41 71 55 36 1A 5C 4B 8D 29 7E 0D 78 }
         $s2 = { 00 8B D5 AD 93 B7 54 D5 00 33 8C 25 3D 9C 17 70 08 F9 0C 1A 41 71 55 36 1A 5C 4B 8D 29 7E 0D 78 }
     condition:
         filesize < 15MB and uint32(0) == 0x464c457f and any of them
 }

rule M_Hunting_Linux_SALTWATER_2
 {
     strings:
         $c1 = "TunnelArgs"
         $c2 = "DownloadChannel"
         $c3 = "UploadChannel"
         $c4 = "ProxyChannel"
         $c5 = "ShellChannel"
         $c6 = "MyWriteAll"
         $c7 = "MyReadAll"
         $c8 = "Connected2Vps"
         $c9 = "CheckRemoteIp"
         $c10 = "GetFileSize"
         $s1 = "[-] error: popen failed"
         $s2 = "/home/product/code/config/ssl_engine_cert.pem"
         $s3 = "libbindshell.so"
     condition:
         filesize < 15MB and uint32(0) == 0x464c457f and (2 of ($s*) or 4 of ($c*))
 }