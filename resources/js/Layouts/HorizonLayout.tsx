// Chakra imports
import { Portal, Box, useDisclosure } from "@chakra-ui/react";
import Footer from "@/Components/footer/FooterAdmin";
// Layout components
import Navbar from "@/Components/navbar/NavbarAdmin";
import Sidebar from "@/Components/sidebar/Sidebar";
import { SidebarContext } from "@/Contexts/SidebarContext";
import { PropsWithChildren, useEffect, useState } from "react";
import { getActiveNavbar, getActiveRoute, isWindowAvailable } from "@/Utils/navigation";
import React from "react"
import { ChakraProvider } from "@chakra-ui/react";
import theme from "@/theme/theme";

interface DashboardLayoutProps extends PropsWithChildren {
  [x: string]: any;
}

const routes: any[] = [];

// Custom Chakra theme
export default function AdminLayout(props: DashboardLayoutProps) {
  const { children, ...rest } = props;
  // states and functions
  const [fixed] = useState(false);
  const [toggleSidebar, setToggleSidebar] = useState(false);
  // functions for changing the states from components
  const { onOpen } = useDisclosure();

  useEffect(() => {
    window.document.documentElement.dir = "ltr";
  });

  return (
    <ChakraProvider theme={theme}>
      <Box>
        <SidebarContext.Provider
          value={{
            toggleSidebar,
            setToggleSidebar,
          }}>
          <Sidebar routes={routes} display="none" {...rest} />
          <Box float="right" minHeight="100vh" height="100%" overflow="auto" position="relative" maxHeight="100%" w={{ base: "100%", xl: "calc( 100% - 290px )" }} maxWidth={{ base: "100%", xl: "calc( 100% - 290px )" }} transition="all 0.33s cubic-bezier(0.685, 0.0473, 0.346, 1)" transitionDuration=".2s, .2s, .35s" transitionProperty="top, bottom, width" transitionTimingFunction="linear, linear, ease">
            <Portal>
              <Box>
                <Navbar onOpen={onOpen} brandText={getActiveRoute(routes)} secondary={getActiveNavbar(routes)} fixed={fixed} {...rest} />
              </Box>
            </Portal>

            <Box mx="auto" p={{ base: "20px", md: "30px" }} pe="20px" minH="90vh" mt="25px">
              {children}
            </Box>
            <Box>
              <Footer />
            </Box>
          </Box>
        </SidebarContext.Provider>
      </Box>
    </ChakraProvider>
  );
}
