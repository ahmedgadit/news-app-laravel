/* eslint-disable */

// chakra imports
import { Box, Flex, HStack, Link, Text, useColorModeValue } from '@chakra-ui/react'
import {
  Accordion,
  AccordionItem,
  AccordionButton,
  AccordionPanel,
  AccordionIcon,
  Stack
} from '@chakra-ui/react'
import { IRoute } from '@/Types/navigation'

interface SidebarLinksProps {
  routes: IRoute[]
}

export function SidebarLinks (props: SidebarLinksProps) {
  const { routes } = props

  //   Chakra color mode

  let activeColor = useColorModeValue('gray.700', 'white')
  let inactiveColor = useColorModeValue(
    'secondaryGray.600',
    'secondaryGray.600'
  )
  let activeIcon = useColorModeValue('brand.500', 'white')
  let textColor = useColorModeValue('secondaryGray.500', 'white')
  let brandColor = useColorModeValue('brand.500', 'brand.400')

  // verifies if routeName is the one active (in browser input)
  const activeRoute = (routeName: string) => {
    return true
  }

  // this function creates the links from the secondary accordions (for example auth -> sign-in -> default)
  const createLinks = (routes: IRoute[]) => {
    return routes.map((route, index: number) => {
      if (
        route.layout === '/admin' ||
        route.layout === '/auth'
      ) {
        return (
            <Link href={'#'}>
            <AccordionItem key={route.name} border='none' borderRadius='3xl'>
                <h2>
                  <AccordionButton py='10px'>
                  <Box
                        color={
                          activeRoute(route.path.toLowerCase())
                            ? activeIcon
                            : textColor
                        }
                        me='18px'
                      >
                        {route.icon}
                      </Box>
                    <Box as="span" flex='1' textAlign='left'>
                      {route.name}
                    </Box>
                    {route.children && <AccordionIcon />}
                  </AccordionButton>
                </h2>

                {route.children && route.children.map((child) => (

                <AccordionPanel pb={4} key={child.name}> 

                    <Stack>
                    <Box as="span" flex='1' textAlign='left'>
                      {child.name}
                    </Box>
                    </Stack>
                  

                </AccordionPanel>
                ))}


                <AccordionPanel pb={4} > 

                    <Stack>
                    <Box as="span" flex='1' textAlign='left'>
                      Hi
                    </Box>
                    </Stack>
                  

                </AccordionPanel>

              </AccordionItem>
              
              
              </Link>
              
          
        )
      }
    })
  }
  //  BRAND
  return (
  <Accordion allowToggle>
    {createLinks(routes)}
  </Accordion>
  )
}

export default SidebarLinks
